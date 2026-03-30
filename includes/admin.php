<?php
// A. Đăng ký Custom Post Type "Sinh viên"
function sm_register_student_cpt() {
    $args = array(
        'public'       => true,
        'label'        => 'Sinh viên',
        'supports'     => array('title', 'editor'), // Hỗ trợ title (Họ tên) và editor (Tiểu sử)
        'menu_icon'    => 'dashicons-welcome-learn-more',
    );
    register_post_type('sinh_vien', $args);
}
add_action('init', 'sm_register_student_cpt');

// B. Tạo Custom Meta Boxes
function sm_add_student_metabox() {
    add_meta_box('sm_student_info', 'Thông tin bổ sung Sinh viên', 'sm_student_metabox_html', 'sinh_vien', 'normal', 'high');
}
add_action('add_meta_boxes', 'sm_add_student_metabox');

// Giao diện nhập liệu (HTML)
function sm_student_metabox_html($post) {
    // TẠO NONCE BẢO MẬT
    wp_nonce_field('sm_save_student_data', 'sm_student_nonce');

    // Lấy dữ liệu cũ ra (nếu có)
    $mssv = get_post_meta($post->ID, '_sm_mssv', true);
    $lop = get_post_meta($post->ID, '_sm_lop', true);
    $ngay_sinh = get_post_meta($post->ID, '_sm_ngaysinh', true);
    ?>
    <p>
        <label><b>Mã số sinh viên (MSSV):</b></label><br>
        <input type="text" name="sm_mssv" value="<?php echo esc_attr($mssv); ?>" style="width:100%;">
    </p>
    <p>
        <label><b>Lớp/Chuyên ngành:</b></label><br>
        <select name="sm_lop" style="width:100%;">
            <option value="CNTT" <?php selected($lop, 'CNTT'); ?>>CNTT</option>
            <option value="Kinh tế" <?php selected($lop, 'Kinh tế'); ?>>Kinh tế</option>
            <option value="Marketing" <?php selected($lop, 'Marketing'); ?>>Marketing</option>
        </select>
    </p>
    <p>
        <label><b>Ngày sinh:</b></label><br>
        <input type="date" name="sm_ngaysinh" value="<?php echo esc_attr($ngay_sinh); ?>" style="width:100%;">
    </p>
    <?php
}

// C. Xử lý dữ liệu (Lưu, Nonce, Sanitize)
function sm_save_student_data($post_id) {
    // 1. Kiểm tra Nonce bảo mật
    if (!isset($_POST['sm_student_nonce']) || !wp_verify_nonce($_POST['sm_student_nonce'], 'sm_save_student_data')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // 2. SANITIZE DỮ LIỆU và LƯU
    if (isset($_POST['sm_mssv'])) {
        update_post_meta($post_id, '_sm_mssv', sanitize_text_field($_POST['sm_mssv']));
    }
    if (isset($_POST['sm_lop'])) {
        update_post_meta($post_id, '_sm_lop', sanitize_text_field($_POST['sm_lop']));
    }
    if (isset($_POST['sm_ngaysinh'])) {
        update_post_meta($post_id, '_sm_ngaysinh', sanitize_text_field($_POST['sm_ngaysinh']));
    }
}
add_action('save_post_sinh_vien', 'sm_save_student_data');