<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('servicePage');
    }

    public function showForm($slug)
    {
        $allowed = ['construction', 'renovation', 'design'];
        if (!in_array($slug, $allowed)) abort(404);

        $labels = [
            'construction' => 'Konstruksi',
            'renovation' => 'Renovasi',
            'design' => 'Desain',
        ];

        $service_label = $labels[$slug] ?? ucfirst($slug);

        return view('serviceForm', [
            'slug' => $slug, 
            'service_label' => $labels[$slug] ?? ucfirst($slug), 
        ]);
    }

    public function detail($slug)
    {
        $services = [
            'construction' => [
                'title' => 'Solusi Konstruksi Profesional untuk Proyek Anda',
                'subtitle' => 'Wujudkan impian pembangunan Anda dengan layanan konstruksi berkualitas tinggi',
                'image' => '/storage/banners/construction.jpg',
                'main_cta' => 'Mulai Layanan Konstruksi',
                'main_cta_url' => route('service.request', ['slug' => 'construction']),
                'sections' => [
                    'Layanan Konstruksi Kami' => [
                        [
                            'icon' => '/storage/icons/planning.png',
                            'title' => 'Perencanaan Konstruksi',
                            'desc' => 'Tim ahli kami akan membantu merencanakan proyek konstruksi Anda secara detail'
                        ],
                        [
                            'icon' => '/storage/icons/build.png',
                            'title' => 'Pelaksanaan Pembangunan',
                            'desc' => 'Eksekusi pembangunan dengan standar kualitas tinggi dan tepat waktu'
                        ],
                        [
                            'icon' => '/storage/icons/monitor.png',
                            'title' => 'Pengawasan Proyek',
                            'desc' => 'Monitoring ketat setiap tahap pembangunan untuk hasil terbaik'
                        ]
                    ]
                ],
                'workflow_title' => 'Proses Kerja Kami',
                'workflow' => [
                    [
                        'step' => '01',
                        'title' => 'Konsultasi Awal',
                        'desc' => 'Diskusi kebutuhan proyek'
                    ],
                    [
                        'step' => '02',
                        'title' => 'Perencanaan & Desain',
                        'desc' => 'Pembuatan konsep detail'
                    ],
                    [
                        'step' => '03',
                        'title' => 'Pelaksanaan Konstruksi',
                        'desc' => 'Implementasi pembangunan'
                    ],
                    [
                        'step' => '04',
                        'title' => 'Quality Control',
                        'desc' => 'Pengawasan & serah terima'
                    ]
                ],
                'cta_title' => 'Siap Memulai Proyek Konstruksi Anda?',
                'cta_subtitle' => 'Konsultasikan kebutuhan konstruksi Anda dengan tim ahli kami',
            ],
            'renovation' => [
                'title' => 'Solusi Renovasi Modern & Fungsional',
                'subtitle' => 'Ubah dan percantik ruangan Anda bersama tim renovasi profesional kami',
                'image' => '/storage/banners/renovation.jpg',
                'main_cta' => 'Mulai Renovasi Sekarang',
                'main_cta_url' => route('service.request', ['slug' => 'renovation']),
                'sections' => [
                    'Layanan Renovasi Kami' => [
                        [
                            'icon' => '/storage/icons/consult.png',
                            'title' => 'Konsultasi & Survey',
                            'desc' => 'Kami datang ke lokasi, mendengarkan kebutuhan renovasi Anda'
                        ],
                        [
                            'icon' => '/storage/icons/remodel.png',
                            'title' => 'Desain Ulang & Remodeling',
                            'desc' => 'Konsep desain ulang sesuai selera dan fungsionalitas'
                        ],
                        [
                            'icon' => '/storage/icons/implement.png',
                            'title' => 'Pelaksanaan Renovasi',
                            'desc' => 'Tim kami mengerjakan dengan rapi, cepat, dan sesuai jadwal'
                        ]
                    ]
                ],
                'workflow_title' => 'Proses Kerja Renovasi',
                'workflow' => [
                    [
                        'step' => '01',
                        'title' => 'Survey Lokasi',
                        'desc' => 'Cek kondisi dan diskusi kebutuhan'
                    ],
                    [
                        'step' => '02',
                        'title' => 'Desain & Rencana Anggaran',
                        'desc' => 'Konsep dan estimasi biaya'
                    ],
                    [
                        'step' => '03',
                        'title' => 'Proses Renovasi',
                        'desc' => 'Pelaksanaan oleh tim ahli'
                    ],
                    [
                        'step' => '04',
                        'title' => 'Finalisasi & Serah Terima',
                        'desc' => 'Pengecekan akhir dan serah terima'
                    ]
                ],
                'cta_title' => 'Tertarik Merenovasi Ruangan?',
                'cta_subtitle' => 'Konsultasikan desain, biaya, dan jadwal renovasi Anda dengan kami!',
            ],
            'design' => [
                'title' => 'Jasa Desain Interior & Eksterior',
                'subtitle' => 'Ciptakan ruang yang indah, nyaman, dan fungsional bersama tim desain kami',
                'image' => '/storage/banners/design.jpg',
                'main_cta' => 'Konsultasi Desain Gratis',
                'main_cta_url' => route('service.request', ['slug' => 'design']),
                'sections' => [
                    'Layanan Desain Kami' => [
                        [
                            'icon' => '/storage/icons/interior.png',
                            'title' => 'Desain Interior',
                            'desc' => 'Penataan ruang dalam yang estetis dan fungsional'
                        ],
                        [
                            'icon' => '/storage/icons/exterior.png',
                            'title' => 'Desain Eksterior',
                            'desc' => 'Konsep fasad, taman, dan ruang luar'
                        ],
                        [
                            'icon' => '/storage/icons/3d.png',
                            'title' => 'Visualisasi 3D',
                            'desc' => 'Tampilan preview realistis sebelum pengerjaan'
                        ]
                    ]
                ],
                'workflow_title' => 'Proses Kerja Desain',
                'workflow' => [
                    [
                        'step' => '01',
                        'title' => 'Konsultasi & Brief',
                        'desc' => 'Pemahaman kebutuhan & gaya'
                    ],
                    [
                        'step' => '02',
                        'title' => 'Konsep Desain',
                        'desc' => 'Presentasi sketsa & moodboard'
                    ],
                    [
                        'step' => '03',
                        'title' => 'Revisi & Finalisasi',
                        'desc' => 'Diskusi & persetujuan desain akhir'
                    ],
                    [
                        'step' => '04',
                        'title' => 'Visualisasi 3D & Deliverables',
                        'desc' => 'Pemberian file & konsultasi pengerjaan'
                    ]
                ],
                'cta_title' => 'Butuh Desain Ruang yang Berbeda?',
                'cta_subtitle' => 'Buat desain ruangan impianmu bersama tim UrbanNest',
            ],
        ];

        if (!array_key_exists($slug, $services)) abort(404);
        $service = $services[$slug];
        return view('serviceDetail', compact('service', 'slug'));
    }

}
