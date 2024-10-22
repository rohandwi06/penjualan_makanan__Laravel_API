<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $order = Order::select('id', 'nama_pelanggan', 'no_meja', 'order_date', 'order_time', 'status', 'total')->get();

        return response(['data' => $order]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //Validasi data input
        $request->validate([
            'nama_pelanggan' => 'required|max:255',
            'no_meja' => 'required'
        ]);


        try {

            DB::beginTransaction();

            //Menginput data untuk tabel orders

            //Data yang bisa diinput hanya 'nama_pelanggan' dan 'no_meja'
            $data = $request->only(['nama_pelanggan', 'no_meja']);

            $data['order_date'] = date('Y-m-d');
            $data['order_time'] = date('H:i:s');
            $data['status'] = 'ordered';
            $data['total'] = 0;
            $data['user_id'] = auth()->user()->id;
            $data['items'] = $request->items;

            $order = Order::create($data);

            //Mengambil data barang-barang atau items yang dibeli dari $data['items']
            collect($data['items'])->map(function($items) use($order) {

                //Membaca input data id barang yang dibeli, kemudian mencocokkan nya dengan id data pada tabel 'items'
                $foodDrink = Item::where('id', $items['id'])->first();

                //Create data pada tabel 'order_details'
                OrderDetail::create([

                    'order_id' => $order->id,
                    'item_id' => $items['id'],
                    'price' => $foodDrink->harga,
                    'qty' => $items['qty'],

                ]);

            });

            //memanggil fungsi dalam model Order, yaitu menghitung total harga dari barang yang dibeli
            $order->total = $order->sumOrderPrice();
            $order->save();

            $data['total'] = $order->total;
            //update $data total agar tidak 0 atau kosong

            DB::commit();

            return $data;

        } catch (\Throwable $th) {

            DB::rollback();

            return response($th);
        }

        // return response(['data' => $order]);

    }


    public function show(string $id)
    {

        $order = Order::findorfail($id);
        return $order->loadMissing(['orderDetail:order_id,price,item_id,qty', 'orderDetail.item:id,nama,harga,image', 'user:id,nama']);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function payment($id) {

        $order = Order::findorfail($id);

        $order->status = 'paid';
        $order->save();

        return response(['data' => $order]);

    }
}
