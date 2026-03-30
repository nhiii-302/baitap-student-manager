<?php
// Tạo Shortcode hiển thị danh sách
function sm_student_shortcode() {
    // Truy vấn dữ liệu Custom Post Type
    $args = array(
        'post_type'      => 'sinh_vien',
        'posts_per_page' => -1, 
        'post_status'    => 'publish'
    );
    $query = new WP_Query($args);
    
    // Bắt đầu vẽ Bảng HTML
    $output = '<div class="sm-table-container">';
    $output .= '<table class="sm-student-table">';
    $output .= '<thead><tr>
                    <th>STT</th>
                    <th>MSSV</th>
                    <th>Họ tên</th>
                    <th>Lớp</th>
                    <th>Ngày sinh</th>
                </tr></thead><tbody>';
    
    if ($query->have_posts()) {
        $stt = 1;
        while ($query->have_posts()) {
            $query->the_post();
            
            // Lấy dữ liệu
            $mssv = get_post_meta(get_the_ID(), '_sm_mssv', true);
            $lop = get_post_meta(get_the_ID(), '_sm_lop', true);
            $ngay_sinh = get_post_meta(get_the_ID(), '_sm_ngaysinh', true);
            $ngay_sinh_dep = $ngay_sinh ? date('d/m/Y', strtotime($ngay_sinh)) : '';

            $output .= '<tr>';
            $output .= '<td>' . $stt++ . '</td>';
            $output .= '<td>' . esc_html($mssv) . '</td>';
            $output .= '<td>' . esc_html(get_the_title()) . '</td>';
            $output .= '<td>' . esc_html($lop) . '</td>';
            $output .= '<td>' . esc_html($ngay_sinh_dep) . '</td>';
            $output .= '</tr>';
        }
        wp_reset_postdata();
    } else {
        $output .= '<tr><td colspan="5" style="text-align:center;">Chưa có dữ liệu.</td></tr>';
    }
    $output .= '</tbody></table></div>';
    
    return $output; // Trả về HTML
}
add_shortcode('danh_sach_sinh_vien', 'sm_student_shortcode');