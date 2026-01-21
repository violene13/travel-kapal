<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BantuanController extends Controller
{
    /**
     * Halaman bantuan utama
     */
    public function index()
    {
        // FAQ statis (tanpa database)
        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara memesan tiket kapal?',
                'jawaban' => 'Kamu bisa memesan tiket kapal melalui menu Pemesanan dengan memilih rute, jadwal, dan melakukan pembayaran.'
            ],
            [
                'pertanyaan' => 'Berapa harga tiket kapal?',
                'jawaban' => 'Harga tiket tergantung rute, kelas kapal, dan waktu keberangkatan.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara menghubungi Customer Service?',
                'jawaban' => 'Kamu dapat menghubungi Customer Service melalui WhatsApp atau email resmi Sealine.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara reschedule tiket kapal?',
                'jawaban' => 'Reschedule dapat dilakukan maksimal 24 jam sebelum keberangkatan melalui menu Pesanan Saya.'
            ],
        ];

        return view('sealine.bantuan.index', compact('faqs'));
    }

    /**
     * Pencarian FAQ (AJAX)
     */
    public function cari(Request $request)
    {
        $keyword = strtolower($request->q);

        $faqs = [
            [
                'pertanyaan' => 'Bagaimana cara memesan tiket kapal?',
                'jawaban' => 'Kamu bisa memesan tiket kapal melalui menu Pemesanan dengan memilih rute, jadwal, dan melakukan pembayaran.'
            ],
            [
                'pertanyaan' => 'Berapa harga tiket kapal?',
                'jawaban' => 'Harga tiket tergantung rute, kelas kapal, dan waktu keberangkatan.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara menghubungi Customer Service?',
                'jawaban' => 'Kamu dapat menghubungi Customer Service melalui WhatsApp atau email resmi Sealine.'
            ],
            [
                'pertanyaan' => 'Bagaimana cara reschedule tiket kapal?',
                'jawaban' => 'Reschedule dapat dilakukan maksimal 24 jam sebelum keberangkatan melalui menu Pesanan Saya.'
            ],
        ];

        // Filter FAQ berdasarkan keyword
        $hasil = array_filter($faqs, function ($faq) use ($keyword) {
            return str_contains(strtolower($faq['pertanyaan']), $keyword);
        });

        return response()->json(array_values($hasil));
    }
}
 