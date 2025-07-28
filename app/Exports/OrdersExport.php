<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::all()->map(function ($order) {
            return [
                'id' => $order->id,
                'customer' => $order->first_name . ' ' . $order->last_name,
                'email' => $order->email,
                'phone' => $order->phone,
                'address' => $order->street_address . ', ' . $order->city . ', ' . $order->state . ', ' . $order->country,
                'total_price' => $order->total_price,
                'status' => $order->status,
                'payment_method' => $order->payment_method,
                'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Customer',
            'Email',
            'Phone',
            'Address',
            'Total Price',
            'Status',
            'Payment Method',
            'Placed At',
        ];
    }
}