<?php

namespace App\Repositories;

use App\Models\Giohang;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class CartRepository extends BaseRepository
{
    public function __construct(
        Giohang $model
    ) {
        $this->model = $model;
    }
    public function cartIndex($user_id)
    {
        // giá bán trong sản phẩm là giá chuẩn
        // giá bán trong variant là giá theo thị trường
        $items = DB::table('giohang')
            ->join('sanpham_variants', 'giohang.sku', '=', 'sanpham_variants.sku')
            ->join('sanpham', 'sanpham_variants.sanpham_id', '=', 'sanpham.id')
            ->leftJoin('variant_attribute_values', 'sanpham_variants.id', '=', 'variant_attribute_values.variant_id')
            ->leftJoin('bienthe_values', 'variant_attribute_values.bienthe_value_id', '=', 'bienthe_values.id')
            ->leftJoin('bienthe', 'bienthe_values.bienthe_id', '=', 'bienthe.id')
            ->where('user_id', $user_id)
            ->select(
                'giohang.id as cart_id',
                'giohang.sku',
                'giohang.soluong as cart_quantity',
                'sanpham.id as product_id',
                'sanpham.tensp',
                'sanpham.discount',
                'sanpham.hinhnen',
                'sanpham.slug',
                'sanpham_variants.giaban',
                'sanpham_variants.soluong as stock_quantity',
                'bienthe_values.value as value',
                'bienthe.type as type',
                'bienthe_values.code as code'
            )
            ->orderBy('giohang.id')
            ->orderBy('bienthe.id')
            ->get();
        return $this->groupedCart($items);
    }
    private function groupedCart($items)
    {
        $grouped = [];
        foreach ($items as $item) {
            $sku = $item->sku;
            // lấy sản phẩm với mã sku
            if (!isset($grouped[$sku])) {
                $grouped[$sku] = [
                    'cart_id' => $item->cart_id,
                    'sku' => $item->sku,
                    'product_id' => $item->product_id,
                    'tensp' => $item->tensp,
                    'hinhnen' => $item->hinhnen,
                    'slug' => $item->slug,
                    'giaban' => $item->giaban,
                    'discount' => $item->discount,
                    'cart_quantity' => $item->cart_quantity,
                    'stock_quantity' => $item->stock_quantity,
                    'subtotal' => ($item->giaban * $item->cart_quantity)
                        * (1 - $item->discount / 100),
                    'attributes' => [],
                ];
            }
            if ($item->value) {
                $grouped[$sku]['attributes'][] = [
                    'type' => $item->type ?? 'Thuộc tính',
                    'value' => $item->value,
                    'code' => $item->code ?? null
                ];
            }
        }
        return $grouped;
    }
    public function getSummary()
    {
        $user_id = Auth::id();
        if (!$user_id) {
            return response()->json([
                'totalQuantity' => 0,
                'totalAmount' => 0
            ]);
        }
        $cartSummary = DB::table('giohang')
            ->join('sanpham_variants', 'giohang.sku', '=', 'sanpham_variants.sku')
            ->where('user_id', $user_id)
            ->select(
                DB::raw('SUM(giohang.soluong) as total_quantity'),
                DB::raw('SUM(sanpham_variants.giaban*giohang.soluong) as total_amount')
            )
            ->first();
        return response()->json([
            'totalQuantity' => $cartSummary->total_quantity ?? 0,
            'totalAmount' => $cartSummary->total_amount ?? 0
        ]);
    }
    public function findByProductAndUser($sanpham_id, $userId)
    {
        return GioHang::where('sanpham_id', $sanpham_id)
            ->where('user_id', $userId)
            ->with('sanpham')
            ->first();
    }
    public function updateQuantity($id, $quantity)
    {
        $result = $this->findById($id);
        $result->update([
            'soluong' => $quantity,
            'update_at' => now()
        ]);
        return $result;
    }
    public function calculateTotals($cartItems, $selectedIds = null)
    {
        $totalQuantity = 0;
        $totalAmount = 0;

        foreach ($cartItems as $item) {
            if ($selectedIds !== null && !in_array($item['cart_id'], $selectedIds)) {
                continue;
            }
            $totalQuantity += $item['cart_quantity'];
            $totalAmount += $item['subtotal'];
        }
        return [
            'totalQuantity' => $totalQuantity,
            'totalAmount' => $totalAmount
        ];
    }
    public function getCheckoutData($cart_ids, $user_id)
    {
        $allCarts = $this->cartIndex($user_id);
        $selectedCarts = array_filter($allCarts, function ($cart) use ($cart_ids) {
            return in_array($cart['cart_id'], $cart_ids);
        });
        if (empty($selectedCarts)) {
            return null;
        }
        $totals = $this->calculateTotals($selectedCarts);
        $totalDiscount = array_reduce($selectedCarts, function ($sum, $cart) {
            return $sum + ($cart['giaban'] * $cart['cart_quantity'] * $cart['discount'] / 100);
        }, 0);
        $checkout = [
            'items' => array_map(function ($cart) {
                return [
                    'cart_id' => $cart['cart_id'],
                    'product_id' => $cart['product_id'],
                    'ten' => $cart['tensp'],
                    'so_luong' => $cart['cart_quantity'],
                    'gia_goc' => $cart['giaban'],
                    'thanh_tien' => $cart['subtotal'],
                    'hinhnen' => $cart['hinhnen'],
                    'discount' => $cart['discount'],
                    'sku' => $cart['sku'],
                    'attributes' => $cart['attributes'],
                ];
            }, $selectedCarts),
            'totalPrice' => $totals['totalAmount'] - $totalDiscount, // Tổng sau giảm
            'totalQuantity' => $totals['totalQuantity'],
            'totalDiscount' => $totalDiscount,
            'totalAmount' => $totals['totalAmount'], // Tổng gốc
            'finalPrice' => $totals['totalAmount'] - $totalDiscount,
        ];

        return $checkout;
    }
    //  public function deleteMultiple($cartIds)
    // {
    //     return Giohang::whereIn('id', $cartIds)->delete();
    // }
}
