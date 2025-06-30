<?php return array(
   'format' => array(
      'long_time' => 'H:m:s d/m/Y',
      'short_time' => 'd/m/Y',
   ),
   'template' => array(
      'form_input' => array(
         'class' => 'form-control col-md-6 col-xs-12',
      ),
      'form_label' => array(
         'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
      ),
      'form_label_edit' => array(
         'class' => 'control-label col-md-4 col-sm-3 col-xs-12',
      ),
      'form_ckeditor' => array(
         'class' => 'form-control col-md-6 col-xs-12 ckeditor',
      ),
      'status' => array(
         'all' => array(
            'name' => 'Tất cả',
            'class' => 'btn-success',
         ),
         'active' => array(
            'name' => 'Kích hoạt',
            'class' => 'btn-success',
         ),
         'inactive' => array(
            'name' => 'Chưa kích hoạt',
            'class' => 'btn-info',
         ),
         'block' => array(
            'name' => 'Bị khóa',
            'class' => 'btn-danger',
         ),
         'default' => array(
            'name' => 'Chưa xác định',
            'class' => 'btn-success',
         ),
      ),
      'is_home' => array(
         'yes' => array(
            'name' => 'Hiển thị',
            'class' => 'btn-primary',
         ),
         'no' => array(
            'name' => 'Không hiển thị',
            'class' => 'btn-warning',
         ),
      ),
      'display' => array(
         'list' => array(
            'name' => 'Danh sách',
         ),
         'grid' => array(
            'name' => 'Lưới',
         ),
      ),
      'type' => array(
         'featured' => array(
            'name' => 'Nổi bật',
         ),
         'normal' => array(
            'name' => 'Bình thường',
         ),
      ),
      'level' => array(
         'admin' => array(
            'name' => 'Quản trị hệ thống',
         ),
         'member' => array(
            'name' => 'Người dùng bình thường',
         ),
      ),
      'search' => array(
         'all' => array(
            'name' => 'Tìm kiếm tất cả',
         ),
         'id' => array(
            'name' => 'ID',
         ),
         'name' => array(
            'name' => 'Tên',
         ),
         'code' => array(
            'name' => 'Mã vận đơn',
         ),
         'username' => array(
            'name' => 'Tên đăng nhập',
         ),
         'full_name' => array(
            'name' => 'Họ tên',
         ),
         'email' => array(
            'name' => 'Email',
         ),
         'description' => array(
            'name' => 'Mô tả',
         ),
         'phone' => array(
            'name' => 'Số điện thoại',
         ),
         'status' => array(
            'name' => 'Nội dung',
         ),
         'customer_code' => array(
            'name' => 'Mã khách hàng',
         ),
         'broker' => array(
            'name' => 'Người môi giới',
         ),
         'broker_percent' => array(
            'name' => 'Phần trăm người hưởng môi giới',
         ),
      ),
      'button' => array(
         'create' => array(
            'class' => 'btn-warning',
            'title' => 'Lên hợp đồng',
            'icon' => 'mdi-arrow-up-bold-box',
            'route-name' => '.create-from-sale',
         ),
         'edit' => array(
            'class' => 'text-primary',
            'title' => 'Edit',
            'icon' => 'ki-outline ki-message-edit fs-2 m-0',
            'route-name' => '.edit',
         ),

         'delete' => array(
            'class' => 'text-danger',
            'title' => 'Delete',
            'icon' => 'ki-outline ki-trash fs-2 m-0',
            'route-name' => '.destroy',
         ),
         'show' => array(
            'class' => '',
            'title' => 'Show',
            'icon' => 'fa-sharp fa-solid fa-eye fs-2 m-0',
            'route-name' => '.show',
         ),
         'approval' => array(
            'class' => 'btn-success ',
            'title' => 'Duyệt',
            'icon' => 'mdi-checkbox-marked-circle text-white',
            'route-name' => '.edit',
         ),
         'history' => array(
            'class' => 'btn-secondary ',
            'title' => 'Xem lịch sử',
            'icon' => 'mdi-backup-restore text-white',
            'route-name' => '.history',
         ),
         'timeline' => array(
            'class' => 'btn-primary ',
            'title' => 'Xem quy trình',
            'icon' => 'mdi-chart-timeline text-white',
            'route-name' => '.timeline',
         ),
         'clone' => array(
            'class' => 'btn-primary ',
            'title' => 'Sao chép',
            'icon' => 'mdi-content-copy text-white btn-clone',
            'route-name' => '.clone-shift',
         ),
         'price' => array(
            'class' => '',
            'title' => 'Bảng giá',
            'icon' => 'fa-regular fa-money-check-dollar-pen text-secondary fa-lg',
            'route-name' => '.date-based-price',
         ),
      ),
   ),

);
