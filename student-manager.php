<?php
/**
 * Plugin Name: Student Manager
 * Description: Plugin quản lý sinh viên (Bài tập WP). Đầy đủ Backend, Frontend, Nonce, Sanitize.
 * Version: 1.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Bảo mật: Không cho truy cập trực tiếp

// Gọi các file chức năng
require_once plugin_dir_path( __FILE__ ) . 'includes/admin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/frontend.php';

// Gọi file CSS làm đẹp bảng
function sm_enqueue_styles() {
    wp_enqueue_style( 'sm-style', plugin_dir_url( __FILE__ ) . 'assets/style.css' );
}
add_action( 'wp_enqueue_scripts', 'sm_enqueue_styles' );