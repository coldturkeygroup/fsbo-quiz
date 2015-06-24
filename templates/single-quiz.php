<?php
/**
 * Template file for displaying single FSBO Quiz
 *
 * @package    WordPress
 * @subpackage FSBO Quiz
 * @author     The Cold Turkey Group
 * @since      1.0.0
 */

global $pf_fsbo_quiz, $wp_query;

$id = get_the_ID();
$title = get_the_title();
$permalink = get_permalink();
$broker = get_post_meta($id, 'legal_broker', true);
$retargeting = get_post_meta($id, 'retargeting', true);
$conversion = get_post_meta($id, 'conversion', true);
$valuator_link = get_post_meta($id, 'home_valuator', true);
$closing_costs = get_post_meta($id, 'closing', true);
$phone = of_get_option('phone_number');
$token = 'pf_fsbo_quiz';
$media = '<img src="' . get_post_meta($id, 'media_file', true) . '" class="img-responsive" style="margin-top:10px">';

// Define our area
if (get_post_meta($id, 'area', true) == 'state') {
    $area = get_option('platform_user_state', 'our state');
} elseif (get_post_meta($id, 'area', true) == 'city') {
    $area = get_option('platform_user_city', 'our city');
} elseif (get_post_meta($id, 'area', true) == 'custom') {
    $area = get_post_meta($id, 'area_custom', true);
} else {
    $area = get_option('platform_user_county', 'Our') . ' County';
}

// Get the page colors
$color_setting = get_post_meta($id, 'primary_color', true);
$color_theme = of_get_option('primary_color');
$hover_setting = get_post_meta($id, 'hover_color', true);
$hover_theme = of_get_option('secondary_color');

if ($color_setting && strlen($color_setting) > 0 && $color_setting != '') {
    $primary_color = $color_setting;
} elseif ($color_theme && strlen($color_theme) > 0 && $color_theme != '') {
    $primary_color = $color_theme;
}

if ($hover_setting && strlen($hover_setting) > 0 && $hover_setting != '') {
    $hover_color = $hover_setting;
} elseif ($hover_theme && strlen($hover_theme) > 0 && $hover_theme != '') {
    $hover_color = $hover_theme;
}

?>
    <!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <title><?php wp_title('&middot;', true, 'right'); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php wp_head(); ?>
        <style>
            <?php
            if( $primary_color != null ) {
                echo '
                .quiz-page .btn-primary {
                    background-color: ' . $primary_color . ' !important;
                    border-color: ' . $primary_color . ' !important; }
                .modal-body h2 {
                    color: ' . $primary_color . ' !important; }
                .quiz-page .question-number {
                    color: ' . $primary_color . ' !important; }
                .quiz-completed i {
                    color: ' . $primary_color . ' !important; }
                .progress-bar {
                  background-color: ' . $primary_color . ' !important; }
                ';
            }
            if( $hover_color != null ) {
                echo '
                .quiz-page .btn-primary:hover,
                .quiz-page .btn-primary:active {
                    background-color: ' . $hover_color . ' !important;
                    border-color: ' . $hover_color . ' !important; }
                ';
            }
            ?>
        </style>
        <link rel="alternate" type="application/rss+xml" title="<?= get_bloginfo('name'); ?> Feed" href="<?= esc_url(get_feed_link()); ?>">
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
    </head>

<body <?php body_class(); ?>>
<div class="quiz-page">
    <form id="fsbo-quiz">
        <div class="container-fluid">
            <div class="row page animated fadeIn">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="landing" data-model="landing">
                    <h3 style="text-align: center;" class="landing-title">Should You Sell Your Home Without A Real Estate Agent?</h3>

                    <h4 style="text-align: center;">Find out if you could save money by selling "For Sale By Owner."</h4>

                    <input class="btn btn-primary btn-lg" id="start-quiz" type="submit" value="Take The Quiz">
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-1" data-model="questionOne">
                    <p class="question-number">1.</p>
                    <h4 class="question-title">Do you need your home to sell in less than 90 days, or are you willing to wait for a potential buyer that might be willing to pay more money?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_one" type="radio" value="a-8">
                            <label><i class="fa fa-fw"></i> My home needs to sell as soon as possible</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_one" type="radio" value="b-2">
                            <label><i class="fa fa-fw"></i> I'm willing to wait for the right price, even if it takes longer</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-2" data-model="questionTwo">
                    <p class="question-number">2.</p>
                    <h4 class="question-title">Realistically, will you be available to schedule showings in 48 hours or less?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_two" type="radio" value="a-8">
                            <label><i class="fa fa-fw"></i> Yes, I will do whatever it takes to be flexible with my schedule</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_two" type="radio" value="b-6">
                            <label><i class="fa fa-fw"></i> Yes, but I can't guarantee I can show the house on short notice (same day)</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_two" type="radio" value="c-0">
                            <label><i class="fa fa-fw"></i> Probably not, but I could respond to emails and send photos to interested buyers</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_two" type="radio" value="d-0">
                            <label><i class="fa fa-fw"></i> I would definitely need more than two days advance notice to prepare for a showing</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-3" data-model="questionThree">
                    <p class="question-number">3.</p>
                    <h4 class="question-title">Are you willing to invest at least $500 in marketing your home (hiring a professional photographer, filming a video, paid advertisements, etc)</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_three" type="radio" value="a-8">
                            <label><i class="fa fa-fw"></i> Yes, I'm willing to spend whatever it takes to sell my home quickly!</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_three" type="radio" value="b-0">
                            <label><i class="fa fa-fw"></i> No, I'd like to keep my costs as low as possible.</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-4" data-model="questionFour">
                    <p class="question-number">4.</p>
                    <h4 class="question-title">Many potential buyers will be working with a licensed real estate agent who will negotiate on their behalf. Do you consider yourself a strong negotiator?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_four" type="radio" value="a-8">
                            <label><i class="fa fa-fw"></i> Yes</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_four" type="radio" value="b-2">
                            <label><i class="fa fa-fw"></i> No, not really</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-5" data-model="questionFive">
                    <p class="question-number">5.</p>
                    <h4 class="question-title">Here in <?= $area ?>, certain price ranges sell a lot faster than other price ranges. What do you think your home is worth right now?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_five" type="radio" value="a-4">
                            <label><i class="fa fa-fw"></i> Less than $150,000</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_five" type="radio" value="b-8">
                            <label><i class="fa fa-fw"></i> $150,000-$300,000</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_five" type="radio" value="c-8">
                            <label><i class="fa fa-fw"></i> $300,000-$600,000</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_five" type="radio" value="d-4">
                            <label><i class="fa fa-fw"></i> $600,000+</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-6" data-model="questionSix">
                    <p class="question-number">6.</p>
                    <h4 class="question-title">Is your home newly renovated/updated, or does it currently need minor upgrades?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_six" type="radio" value="a-4">
                            <label><i class="fa fa-fw"></i> It definitely needs some work. I would need to make repairs and upgrades before selling.</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_six" type="radio" value="b-6">
                            <label><i class="fa fa-fw"></i> It needs some cosmetic repairs, but nothing major (new paint, etc)</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_six" type="radio" value="c-8">
                            <label><i class="fa fa-fw"></i> It's pretty updated (newer appliances, newer interior)</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_six" type="radio" value="d-8">
                            <label><i class="fa fa-fw"></i> My house is completely updated with brand new appliances, brand new interior (flooring, walls, etc)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-7" data-model="questionSeven">
                    <p class="question-number">7.</p>
                    <h4 class="question-title">What is the approximate age of your home?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_seven" type="radio" value="a-8">
                            <label><i class="fa fa-fw"></i> It's less than 5 years old</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_seven" type="radio" value="b-6">
                            <label><i class="fa fa-fw"></i> It's 5-20 years old</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_seven" type="radio" value="c-6">
                            <label><i class="fa fa-fw"></i> 20-50 years old</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_seven" type="radio" value="d-4">
                            <label><i class="fa fa-fw"></i> 50 years+</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-8" data-model="questionEight">
                    <p class="question-number">8.</p>
                    <h4 class="question-title">What is the condition of your roof/shingles?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_eight" type="radio" value="a-8">
                            <label><i class="fa fa-fw"></i> It's brand new</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_eight" type="radio" value="b-8">
                            <label><i class="fa fa-fw"></i> Less than 5 years old</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_eight" type="radio" value="c-8">
                            <label><i class="fa fa-fw"></i> Less than 15 years old</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_eight" type="radio" value="d-4">
                            <label><i class="fa fa-fw"></i> It probably needs to be replaced</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-9" data-model="questionNine">
                    <p class="question-number">9.</p>
                    <h4 class="question-title">Sometimes a home sale can affect your tax liability. Have you already spoken with an accountant?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_nine" type="radio" value="a-8">
                            <label><i class="fa fa-fw"></i> Yes</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_nine" type="radio" value="b-8">
                            <label><i class="fa fa-fw"></i> No</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-10" data-model="questionTen">
                    <p class="question-number">10.</p>
                    <h4 class="question-title">Are you prepared to "stage" your house during the time it is for sale? (Removing personal items like family photos, artwork, and rearranging furniture/layout so potential buyers can visualize it being
                        <em>their</em> home—not yours).</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_ten" type="radio" value="a-8">
                            <label><i class="fa fa-fw"></i> Yes, I'm willing to do whatever it takes to sell my home quickly and for top dollar—even if it means I have to temporarily take down family photos, get the house professionally cleaned, and maybe even paint rooms neutral colors to appeal to buyers.</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_ten" type="radio" value="b-8">
                            <label><i class="fa fa-fw"></i> Yes, I'm willing to stage my home to appeal to buyers, however, I don't want to go overboard and spend a lot of time on it.</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_ten" type="radio" value="c-6">
                            <label><i class="fa fa-fw"></i> No, I believe my home will sell anyways, so I don't want to spend too much time on staging.</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_ten" type="radio" value="d-4">
                            <label><i class="fa fa-fw"></i> No, I do not have the time or money to stage my home.</label>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($closing_costs == 'no') { ?>
                <div class="row page" style="display:none;">
                    <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-11" data-model="questionEleven">
                        <p class="question-number">11.</p>
                        <h4 class="question-title">Does your home's exterior showcase good "curb appeal?"</h4>

                        <div class="row">
                            <div class="col-xs-12">
                                <input name="question_eleven" type="radio" value="a-8">
                                <label><i class="fa fa-fw"></i> Yes, I take good care of my lawn, landscaping, etc.</label>
                            </div>
                            <div class="col-xs-12">
                                <input name="question_eleven" type="radio" value="b-2">
                                <label><i class="fa fa-fw"></i> It's not bad, but it could use some work.</label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="row page" style="display:none;">
                    <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-11" data-model="questionEleven">
                        <p class="question-number">11.</p>
                        <h4 class="question-title">Are you willing to share closing costs with the potential buyer?</h4>

                        <div class="row">
                            <div class="col-xs-12">
                                <input name="question_eleven" type="radio" value="a-8">
                                <label><i class="fa fa-fw"></i> Yes</label>
                            </div>
                            <div class="col-xs-12">
                                <input name="question_eleven" type="radio" value="b-2">
                                <label><i class="fa fa-fw"></i> No</label>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-12" data-model="questionTwelve">
                    <p class="question-number">12.</p>
                    <h4 class="question-title">Have you made any significant upgrades or renovations to your home since you purchased it?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_twelve" type="radio" value="a-6">
                            <label><i class="fa fa-fw"></i> Yes, I've renovated/upgraded the bathroom</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_twelve" type="radio" value="b-6">
                            <label><i class="fa fa-fw"></i> Yes, I've renovated/upgraded the kitchen</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_twelve" type="radio" value="c-8">
                            <label><i class="fa fa-fw"></i> Yes, I've renovated/upgraded most of the house (kitchen, bathroom, bedrooms, living space, etc.)</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_twelve" type="radio" value="d-4">
                            <label><i class="fa fa-fw"></i> No, I have not made any significant improvements</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="question-13" data-model="questionThirteen">
                    <p class="question-number">13.</p>
                    <h4 class="question-title">Have you budgeted some money to have your home professionally cleaned?</h4>

                    <div class="row">
                        <div class="col-xs-12">
                            <input name="question_thirteen" type="radio" value="a-8">
                            <label><i class="fa fa-fw"></i> Yes, I will definitely invest money in a professional cleaner</label>
                        </div>
                        <div class="col-xs-12">
                            <input name="question_thirteen" type="radio" value="b-2">
                            <label><i class="fa fa-fw"></i> No, but I will personally make sure the home is spotless!</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row page" style="display:none;">
                <div class="col-xs-10 col-xs-offset-1 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2" id="offer" data-model="offer">
                    <h4 style="text-align: center;" class="landing-title">Awesome. Click below to see your quiz results!</h4>

                    <button class="btn btn-primary btn-lg" id="get-results">Get My Results!</button>
                </div>
            </div>
        </div>

        <div class="footer"><?php echo $broker;
            if ($phone != null) {
                echo ' &middot; ' . $phone;
            } ?></div>
        <div class="footer-quiz" style="display:none;">
            <div class="broker"><?php echo $broker;
                if ($phone != null) {
                    echo ' &middot; ' . $phone;
                } ?>
            </div>

            <div class="quiz-progress">
                <span class="progress-percent">8</span>% complete
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100" style="width: 8%;">
                        <span class="sr-only"><span class="progress-percent">8</span>% Complete</span>
                    </div>
                </div>
            </div>

            <div class="quiz-back btn btn-primary" id="quiz-back" style="display:none;"><i class="fa fa-chevron-up"></i>
            </div>
        </div>

        <div class="modal fade" id="quiz-results" tabindex="-1" role="dialog" aria-labelledby="quiz-results-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Awesome! Your quiz results have been calculated. <br> Where should we email your results?
                        </h3>

                        <div class="form-group">
                            <label for="first_name" class="control-label sr-only">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required="required" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label sr-only">Email Address</label>
                            <input type="text" name="email" id="email" class="form-control" required="required" placeholder="Email Address">
                        </div>

                        <input name="permalink" type="hidden" value="<?= $permalink; ?>">
                        <input name="action" type="hidden" id="<?= $token ?>_submit_quiz" value="<?= $token ?>_submit_quiz">
                        <?php wp_nonce_field($token . '_submit_quiz', $token . '_nonce'); ?>
                        <input name="quiz_id" type="hidden" value="<?= $id ?>">

                        <input type="submit" class="btn btn-primary btn-lg" id="submit-results" value="Get My Results!">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    if ($valuator_link != '') {
        echo '<input type="hidden" id="valuator-link" value="' . $valuator_link . '">';
    }

    if ($retargeting != '') {
        echo '<input type="hidden" id="retargeting" value="' . $retargeting . '">';
    }

    if ($conversion != '') {
        echo '<input type="hidden" id="conversion" value="' . $conversion . '">';
    }
    ?>
</div>

<?php wp_footer(); ?>