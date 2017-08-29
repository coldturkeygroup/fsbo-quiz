<?php
/*
 * Plugin Name: FSBO Quiz
 * Version: 1.4.8
 * Plugin URI: http://www.coldturkeygroup.com/
 * Description: Multiple choice quiz to help potential home owners decide whether or not they're ready to sell.
 * Author: Cold Turkey Group
 * Author URI: http://www.coldturkeygroup.com/
 * Requires at least: 4.0
 * Tested up to: 4.3
 *
 * @package FSBO Quiz
 * @author Aaron Huisinga
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('FSBO_QUIZ_PLUGIN_PATH')) {
    define('FSBO_QUIZ_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
}

if (!defined('FSBO_QUIZ_PLUGIN_VERSION')) {
    define('FSBO_QUIZ_PLUGIN_VERSION', '1.4.8');
}

require_once('classes/class-fsbo-quiz.php');

global $seller_quiz;
$seller_quiz = new ColdTurkey\FSBOQuiz\FSBOQuiz(__FILE__);

if (is_admin()) {
    require_once('classes/class-fsbo-quiz-admin.php');
    $seller_quiz_admin = new ColdTurkey\FSBOQuiz\FSBOQuiz_Admin(__FILE__);
}
