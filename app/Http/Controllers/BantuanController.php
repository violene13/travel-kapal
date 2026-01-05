<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BantuanController extends Controller
{
    
    public function index()
    {
        // Contoh data FAQ 
        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara memesan tiket kapal?',
                'jawaban' => 'Kamu bisa memesan tiket kapal melalui halaman utama dengan memilih jadwal, rute, dan metode pembayaran yang diinginkan.'
            ],
            [
                'pertanyaan' => 'Berapa harga tiket kapal?',
                'jawaban' => 'Harga tiket kapal bervariasi tergantung rute, kelas kapal, dan waktu keberangkatan. Kamu dapat melihat detail harga di halaman pemesanan.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara menghubungi Customer Service?',
                'jawaban' => 'Kamu dapat menghubungi kami melalui WhatsApp di +62 812-3456-7890 atau email ke cs@sealine.com.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara reschedule tiket kapal?',
                'jawaban' => 'Kamu dapat melakukan permintaan perubahan jadwal melalui menu “Pesanan Saya” maksimal 24 jam sebelum keberangkatan.'
            ],
        ];

        return view('sealine.bantuan.index', compact('faqs'));
    }

    // pencarian FAQ
     
    public function cari(Request $request)
    {
        $keyword = strtolower($request->input('q'));

        //  data FAQ statis
        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara memesan tiket kapal?',
                'jawaban' => 'Kamu bisa memesan tiket kapal melalui halaman utama dengan memilih jadwal, rute, dan metode pembayaran yang diinginkan.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara menghubungi Customer Service?',
                'jawaban' => 'Kamu dapat menghubungi kami melalui WhatsApp di +62 812-3456-7890 atau email ke cs@sealine.com.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara reschedule tiket kapal?',
                'jawaban' => 'Kamu dapat melakukan permintaan perubahan jadwal melalui menu “Pesanan Saya” maksimal 24 jam sebelum keberangkatan.'
            ],
        ];

        // Filter FAQ yang cocok
        $hasil = array_filter($faqs, function ($faq) use ($keyword) {
            return str_contains(strtolower($faq['pertanyaan']), $keyword);
        });

        return response()->json(array_values($hasil));
    }
}
