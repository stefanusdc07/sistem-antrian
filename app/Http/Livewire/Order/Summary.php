<?php

namespace App\Http\Livewire\Order;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Order;

class Summary extends Component
{

    public $modalTitle;
    public $ordersData = [];

    public function render()
    {
        //QUERY SUMMARY DATA PASIEN
        $totalToday = Order::where('day', Carbon::now()->format('Y-m-d'))->count(); //QUERY UNTUK MENGAMBIL TOTAL APPOINTMENT HARI INI
        $onQueue = Order::where('day', Carbon::now()->format('Y-m-d'))->whereIn('status', [0, 1])->count(); //QUERY UNTUK MENGAMBIL TOTAL APPOINTMENT HARI INI DENGAN SYARAT MASIH DALAM ANTRIAN (0) / SEDANG DILAYANI (1)
        $complete = Order::where('day', Carbon::now()->format('Y-m-d'))->where('status', 2)->count(); //QUERY UNTUK MENGAMBIL TOTAL APPOINTMENT HARI INI DENGAN SYARAT SUDAH SELESAI (2)
        $total = Order::whereIn('status', [2,3])->count(); //QUERY UNTUK MENGAMBIL TOTAL APPOINTMENT HARI INI DENGAN STATUS SELESAI / DIBATALKAN

        return view('livewire.order.summary', compact('totalToday', 'onQueue', 'complete', 'total'));
    }

    public function openModal($title, $modalType)
    {
        $this->modalTitle = $title; //PARAMETER TITLE YG DIKIRIM KITA SIMPAN KE DALAM PROPERTY INI

        //CODE: 1: TOTAL PASIEN HARI INI, 2: ANTRIAN HARI INI, 3: TERTANGANI HARI INI, 4: TOTAL PASIEN
      
        //JIKA YANG DI MINTA ADALAH TOTAL PASIEN (4)
        if ($modalType == 4) {
            //BUAT QUERY UNTUK MENGAMBIL SEMUA DATA DENGAN STATUS SELESAI (2) & DIBATALKAN (3) DAN DIURUTKAN BERDASARKAN DATA TERBARU
            $ordersData = Order::with(['daily_slot'])->whereIn('status', [2, 3])->orderBy('created_at', 'DESC')->get();
        } else {
          //SELAIN ITU, KITA BUAT QUERY DATA HARI INI
            $ordersData = Order::with(['daily_slot'])->where('day', Carbon::now()->format('Y-m-d'))
                //DENGAN KETENTUAN
                ->when($modalType, function($query) use($modalType) {
                  //JIKA YG DIMINTA ADALAH ANTRIAN HARI INI (2)
                    if ($modalType == 2) {
                        //MAKA FILTER STATUS DALAM ANTRIAN (0) DAN SEDANG DILAYANI (1)
                        $query->whereIn('status', [0, 1]);
                    //JIKA YG DIMINTA ADALAH DATA YG SUDAH SELESAI
                    } elseif ($modalType == 3) {
                      //MAKA FILTER STATUS PASIEN YANG SUDAH DILAYANI (2)
                        $query->where('status', 2);
                    }
                })
                ->orderBy('daily_slot_id', 'ASC') //URUTKAN BERDASARKAN DAILY SLOT, AGAR YANG DITAMPILKAN LEBIH DAHULU ADALAH DATA PAGI HARI, SORE LALU MALAM
                ->orderBy('created_at', 'ASC') //KEMUDIAN URUTKAN BERDASARKAN DATA YANG LEBIH DAHULU MEMBUAT APPOINTMENT
                ->get();
        }
        
        $this->ordersData = $ordersData; //SIMPAN DATA TERSEBUT KE DALAM PROEPRTY TERKAIT
    }
}