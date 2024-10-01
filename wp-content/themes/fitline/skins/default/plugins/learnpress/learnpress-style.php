<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'fitline_booked_get_css' ) ) {
    add_filter( 'fitline_filter_get_css', 'fitline_booked_get_css', 10, 2 );
    function fitline_booked_get_css( $css, $args ) {

        if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
            $fonts         = $args['fonts'];
            $css['fonts'] .= <<<CSS

#learn-press-profile.lp-user-profile #profile-content #learnpress-avatar-upload .learnpress_avatar__button,
div.lp-list-instructors .ul-list-instructors li.item-instructor .instructor-btn-view,
.lp-form-course-filter .course-filter-submit,
.lp-form-course-filter .course-filter-reset,
.learnpress #learn-press-profile-basic-information button[type="submit"],
.learnpress-page .lp-button,
.learnpress-page #lp-button,
.lp-widget-recent-courses [class*="-courses__footer__link"],
.lp-widget-popular-courses [class*="-courses__footer__link"],
.lp-widget-featured-courses [class*="-courses__footer__link"],
.lp-archive-courses .learn-press-courses[data-layout="list"] .course .course-item .course-content .course-readmore a {
	{$fonts['button_font-family']}
	{$fonts['button_font-size']}
	{$fonts['button_font-weight']}
	{$fonts['button_font-style']}
	{$fonts['button_line-height']}
	{$fonts['button_text-decoration']}
	{$fonts['button_text-transform']}
	{$fonts['button_letter-spacing']}
}
.course-rate .course-rate__summary-value,
.instructor-total-courses,
#learn-press-profile.lp-user-profile #profile-content #profile-content-settings .learn-press-form .form-fields .form-field label,
div.lp-list-instructors .ul-list-instructors li.item-instructor .instructor-display-name,
.lp-single-instructor .ul-instructor-courses .course-count div,
.lp-list-instructors .ul-list-instructors li.item-instructor .instructor-info > div,
.lp-single-instructor .ul-instructor-courses .price-categories .course-categories a,
.lp-form-course-filter .lp-form-course-filter__item .lp-form-course-filter__title,
#popup-course #popup-footer .course-item-nav a,
.learn-press-course-tab-enrolled .lp_profile_course_progress__item a,
.learnpress.widget_course_info .lp_widget_course_info ul label, .elementor-widget-wp-widget-learnpress_widget_course_info .lp_widget_course_info ul label,
#profile-content .recover-order__title,
#learn-press-course .course-sidebar-preview .course-time .course-time-row strong,
#learn-press-profile .wrapper-profile-header .lp-profile-username,
#learn-press-profile .statistic-box .statistic-box__text,
#learn-press-profile #profile-nav .lp-profile-nav-tabs > li a,
.learn-press-profile-course__tab__inner a,
.learn-press-filters > li a,
#popup-course #popup-footer .course-item-nav .course-item-nav__name,
#popup-course #popup-sidebar .course-item .item-name,
.course-tab-panel-faqs .course-faqs-box__title,
.lp-widget-course__meta,
.learn-press-courses .course .course-price .price, .learnpress-widget-wrapper .lp-widget-course__price, .course-summary-sidebar .course-price,
#learn-press-course-tabs .course-nav label,
.lp-archive-courses .course .course-item .course-content .course-categories a,
.lp-archive-courses .course .course-item .course-content .meta-item,
.lp-archive-courses .course-summary .course-summary-content .course-detail-info .course-info-left .course-meta .course-meta__pull-left .meta-item {
	{$fonts['h5_font-family']}
}

.course-extra-box__content li,
#popup-course #popup-content #learn-press-content-item .content-item-wrap .content-item-summary .content-item-description p,
.lp-archive-courses .learn-press-courses .course .course-item .course-content .course-info .course-excerpt,
.lp-archive-courses .learn-press-courses .course .course-item .course-content .course-info,
#learn-press-course .lp-course-author .course-author__pull-right .author-description,
#learn-press-course-tabs.course-tabs #learn-press-course-curriculum.course-curriculum ul.curriculum-sections .section-header .section-desc,
#learn-press-course-tabs .course-tab-panels .course-tab-panel .course-description p {
	{$fonts['p_font-family']}
	{$fonts['p_font-size']}
	{$fonts['p_font-weight']}
	{$fonts['p_line-height']}
	{$fonts['p_font-style']}
}

CSS;
        }

        return $css;
    }
}