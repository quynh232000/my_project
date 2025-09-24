<?php
return [
    'title' => [
        'index'  => 'Quản lý ca làm việc',
        'clone-shift'  => 'Bản sao của',
    ],
    'card' => [
        'title' => 'Ca làm việc'
    ],
    'search' => [
        'fields' => [
            'ma-ca-lam-viec' => 'Mã ca làm việc',
            'ten-ca-lam-viec' => 'Ca làm việc',
        ]
    ],
    'form' => [
        'fields' => [
            'ca-lam-viec'            => 'Ca làm việc',
            'bat-dau-vao'            => 'Bắt đầu vào',
            'gio-vao-lam-viec'       => 'Giờ vào làm việc',
            'ket-thuc-vao'           => 'Kết thúc vào',
            'gio-bat-dau-nghi-trua'  => 'Giờ bắt đầu nghỉ trưa',
            'gio-ket-thuc-nghi-trua' => 'Giờ kết thúc nghỉ trưa',
            'bat-dau-ra'             => 'Bắt đầu ra',
            'gio-ket-thuc-lam-viec'  => 'Giờ kết thúc làm việc',
            'ket-thuc-ra'            => 'Kết thúc ra',
            'cong-tinh'              => [
                'name' => 'Công tính',
                'value' => [
                    'du-cong' => '01 Công',
                    'nua-cong' => '0.5 Công',
                ],
            ],
            'loai-ca'                => [
                'name' => 'Loại ca (Ngày/Đêm)',
                'value' => [
                    'ca-ngay' => 'Ca ngày',
                    'ca-dem' => 'Ca đêm',
                ]
            ],
            'cho-phep-di-tre'        => 'Cho phép đi trễ',
            'cho-phep-ve-som'        => 'Cho phép về sớm',
        ],
        'placeholder' => [
            'so-phut' => 'Số phút'
        ]
    ],
    'button' => [
        'sao-chep-tu-ca-co-san' => 'Sao chép từ ca có sẵn'
    ],
    'description' => [
        'mau-sac' => ['name' => 'Màu sắc'],
        'dien-giai' => [
            'name' => 'Diễn giải',
            'value' => [
                'ngoai-gio-lam-viec' => 'Ngoài giờ làm việc',
                'truoc-sau-gio-lam-viec' => 'Trước/sau giờ làm việc',
                'ca-lam-viec' => 'Ca làm việc',
                'nghi-giua-gio' => 'Nghỉ giữa giờ',
            ]
        ],
        'cham-cong' => ['name' => 'Chấm công'],
    ]
];