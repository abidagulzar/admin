<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();




Route::get('/', 'Site\HomeController@index')->name("site.home");
Route::get('sitesearch/{keyword}', 'Site\HomeController@siteSearch')->name("site.siteSearch");
Route::get('/stores', 'Site\StoreController@storeList');
Route::get('/stores/{keyword?}', 'Site\StoreController@storeList')->name("site.storelist");
Route::get('view/{storeSearchName?}', 'Site\StoreController@storeDetail')
    ->where('storeSearchName', '(.*)');
Route::get('error/{storeSearchName?}', 'Site\StoreController@CheckError')
    ->where('storeSearchName', '(.*)');
Route::get('event/{specialpageURL?}', 'Site\SpecialPageController@index')
    ->where('specialpageURL', '(.*)');
Route::get('offer/{keyword}', 'Site\OfferController@storeoffer')->name("site.socialoffer");

Route::get('/categories', 'Site\CategoryController@categoryList');
Route::get('category/{categorySearchName?}', 'Site\CategoryController@categoryDetail')
    ->where('categorySearchName', '(.*)');


Route::get('{store}-coupon-and-deals/{couponid?}', 'Site\CouponController@CouponPopup')
    ->where('store', '(.*)')->where('couponid', '(.*)')->name("site.couponPopUpUrl");

Route::get('cpc-store-log/{sourcestoreid}/{targetstoreid}', 'Site\CouponController@CPCPopUrl')
    ->where('sourcestoreid', '(.*)')->where('targetstoreid', '(.*)')->name("site.cpcPopUrl");

Route::get('offerdetail/{socialMediaID?}', 'Site\SocialMediaController@socialOffer')->name("site.socialMediaOffer");

Route::match(
    array('GET'),
    '/contactus',
    'Site\UserMessageController@create'
)->name("site.contactus");

Route::match(
    array('GET'),
    '/suggestion',
    'Site\SuggestionController@create'
)->name("site.suggestion");

Route::match(
    array('POST'),
    '/suggestion',
    'Site\SuggestionController@createpost'
)->name("site.createpost");

Route::match(
    array('GET'),
    '/aboutus',
    'Site\SiteInfoController@AboutUs'
)->name("site.aboutus");

Route::match(
    array('POST'),
    '/contactus',
    'Site\UserMessageController@contactuspost'
)->name("site.contactuspost");

Route::match(
    array('GET'),
    '/submitcoupon',
    'Site\SubmittedCouponController@create'
)->name("site.submittedcoupon");

Route::match(
    array('POST'),
    '/submitcoupon',
    'Site\SubmittedCouponController@createpost'
)->name("site.submittedcouponpost");

Route::match(
    array('POST'),
    '/subscribe',
    'Site\UserMessageController@subscribe'
)->name("site.subscribe");


Route::get('/termsofuse', 'Site\SiteInfoController@TermsOfUse');
Route::get('/privacypolicy', 'Site\SiteInfoController@PrivacyPolicy');
Route::get('/sitemap.xml', 'Site\SiteInfoController@Sitemap');


Route::match(
    array('GET', 'POST'),
    'admin/login',
    'Auth\LoginController@index'
)->name("user.login");


Route::post('auth/login/authenticate', 'Auth\LoginController@authenticate')->name("user.authenticate");
Route::get('logout', 'Auth\LoginController@logout')->name("logout");



Route::group(['middleware' => ['auth']], function () {
    Route::post('admin/user/editpost', 'Admin\UserController@updatepost')->name("admin.user.updatepost");


    Route::match(
        array('GET', 'POST'),
        'admin/user/create',
        'Admin\UserController@create'
    )->name("admin.user.create");

    Route::post('admin/user/createpost', 'Admin\UserController@createpost')->name("admin.user.createpost");
    Route::get('admin/user/{id}', 'Admin\UserController@show')->name("admin.user.show");
    Route::get('admin/user', 'Admin\UserController@index')->name("admin.user.index");
    Route::post('admin/user/delete', 'Admin\UserController@delete')->name("admin.user.delete");
    Route::get('admin/user/edit/{id}', 'Admin\UserController@edit')->name("admin.user.edit");
    Route::get('admin/user/userinfo/{id}', 'Admin\UserController@userinfo')->name("admin.user.userinfo");
    Route::post('admin/user/updatepassword', 'Admin\UserController@updatepassword')->name("admin.user.updatepassword");
    Route::get('admin/user/resetpassword/{id}', 'Admin\UserController@resetpassword')->name("admin.user.resetpassword");



    Route::post('admin/role/editpost', 'Admin\RoleController@updatepost')->name("admin.role.updatepost");

    Route::match(
        array('GET', 'POST'),
        'admin/role/create',
        'Admin\RoleController@create'
    )->name("admin.role.create");

    Route::post('admin/role/createpost', 'Admin\RoleController@createpost')->name("admin.role.createpost");
    Route::get('admin/role/{id}', 'Admin\RoleController@show')->name("admin.role.show");
    Route::get('admin/role', 'Admin\RoleController@index')->name("admin.role.index");
    Route::post('admin/role/delete', 'Admin\RoleController@delete')->name("admin.role.delete");
    Route::get('admin/role/edit/{id}', 'Admin\RoleController@edit')->name("admin.role.edit");
    Route::get('admin/role/roleinfo/{id}', 'Admin\RoleController@roleinfo')->name("admin.role.roleinfo");

    Route::post('admin/store/editpost', 'Admin\StoreController@updatepost')->name("admin.store.updatepost");

    Route::match(
        array('GET', 'POST'),
        'admin/store/create',
        'Admin\StoreController@create'
    )->name("admin.store.create");

    Route::post('admin/store/createpost', 'Admin\StoreController@createpost')->name("admin.store.createpost");
    Route::get('admin/store/{id}', 'Admin\StoreController@show')->name("admin.store.show");
    Route::get('admin/store', 'Admin\StoreController@index')->name("admin.store.index");
    Route::post('admin/store/delete', 'Admin\StoreController@delete')->name("admin.store.delete");
    Route::get('admin/store/edit/{id}', 'Admin\StoreController@edit')->name("admin.store.edit");
    Route::get('admin/store/storeinfo/{id}', 'Admin\StoreController@storeinfo')->name("admin.store.storeinfo");


    Route::match(
        array('GET', 'POST'),
        'admin/cpcstore/create',
        'Admin\CPCStoreController@create'
    )->name("admin.cpcstore.create");


    Route::get('admin/cpcstore', 'Admin\CPCStoreController@index')->name("admin.cpcstore.index");
    Route::get('admin/cpcstore/edit/{id}', 'Admin\CPCStoreController@edit')->name("admin.cpcstore.edit");
    Route::get('admin/cpcstore/editall/{id}', 'Admin\CPCStoreController@editall')->name("admin.cpcstore.editall");
    Route::post('admin/cpcstore/createpost', 'Admin\CPCStoreController@createpost')->name("admin.cpcstore.createpost");
    Route::post('admin/cpcstore/delete', 'Admin\CPCStoreController@delete')->name("admin.cpcstore.delete");
    Route::post('admin/cpcstore/updatepost', 'Admin\CPCStoreController@updatepost')->name("admin.cpcstore.updatepost");



    Route::post('admin/socialmedia/editpost', 'Admin\SocialMediaController@updatepost')->name("admin.socialmedia.updatepost");

    Route::match(
        array('GET', 'POST'),
        'admin/socialmedia/create',
        'Admin\SocialMediaController@create'
    )->name("admin.socialmedia.create");

    Route::post('admin/socialmedia/createpost', 'Admin\SocialMediaController@createpost')->name("admin.socialmedia.createpost");
    Route::get('admin/socialmedia/{id}', 'Admin\SocialMediaController@show')->name("admin.socialmedia.show");
    Route::get('admin/socialmedia', 'Admin\SocialMediaController@index')->name("admin.socialmedia.index");
    Route::post('admin/socialmedia/delete', 'Admin\SocialMediaController@delete')->name("admin.socialmedia.delete");
    Route::get('admin/socialmedia/edit/{id}', 'Admin\SocialMediaController@edit')->name("admin.socialmedia.edit");
    Route::get('admin/socialmedia/socialmediainfo/{id}', 'Admin\SocialMediaController@socialmediainfo')->name("admin.socialmedia.socialmediainfo");




    Route::match(
        array('GET', 'POST'),
        'admin/specialpage/create',
        'Admin\SpecialPageController@create'
    )->name("admin.specialpage.create");

    Route::post('admin/specialpage/createpost', 'Admin\SpecialPageController@createpost')->name("admin.specialpage.createpost");
    Route::get('admin/specialpage/rank', 'Admin\SpecialPageController@couponrank')->name("admin.specialpage.couponrank");
    Route::get('admin/specialpage/{id}', 'Admin\SpecialPageController@show')->name("admin.specialpage.show");
    Route::get('admin/specialpage', 'Admin\SpecialPageController@index')->name("admin.specialpage.index");
    Route::post('admin/specialpage/delete', 'Admin\SpecialPageController@delete')->name("admin.specialpage.delete");
    Route::get('admin/specialpage/edit/{id}', 'Admin\SpecialPageController@edit')->name("admin.specialpage.edit");
    Route::post('admin/specialpage/updatepost', 'Admin\SpecialPageController@updatepost')->name("admin.specialpage.updatepost");
    Route::get('admin/specialpage/GetCouponForRank/{id}', 'Admin\SpecialPageController@GetCouponForRank')->name("admin.specialpage.getcouponforrank");
    Route::post('admin/specialpage/updaterank', 'Admin\SpecialPageController@updaterank')->name("admin.specialpage.updaterank");


    Route::match(
        array('GET', 'POST'),
        'admin/category/create',
        'Admin\CategoryController@create'
    )->name("admin.category.create");
    Route::post('admin/category/editpost', 'Admin\CategoryController@updatepost')->name("admin.category.editpost");
    Route::post('admin/category/createpost', 'Admin\CategoryController@createpost')->name("admin.category.createpost");
    Route::post('admin/category/delete', 'Admin\CategoryController@delete')->name("admin.category.delete");
    Route::get('admin/category/edit/{id}', 'Admin\CategoryController@edit')->name("admin.category.edit");
    Route::get('admin/category', 'Admin\CategoryController@index')->name("admin.category.index");


    Route::get('admin/usercoupon', 'Admin\UserCouponController@index')->name("admin.usercoupon.index");
    Route::get('admin/visitor', 'Admin\VisitorController@index')->name("admin.visitor.index");
    Route::get('admin/visitor/coupon', 'Admin\VisitorController@coupon')->name("admin.visitor.coupon");
    Route::get('admin/visitor/cpc', 'Admin\VisitorController@cpcOfflineVisitors')->name("admin.visitor.cpcOfflineVisitors");
    Route::get('admin/storevisitoranalysis', 'Admin\StoreVisitorAnalysisController@index')->name("admin.storevisitoranalysis.index");

    Route::match(
        array('GET', 'POST'),
        'admin/excludetrafficip/create',
        'Admin\ExcludeTrafficIPController@create'
    )->name("admin.excludetrafficip.create");
    Route::post('admin/excludetrafficip/updatepost', 'Admin\ExcludeTrafficIPController@updatepost')->name("admin.excludetrafficip.updatepost");
    Route::post('admin/excludetrafficip/createpost', 'Admin\ExcludeTrafficIPController@createpost')->name("admin.excludetrafficip.createpost");
    Route::post('admin/excludetrafficip/delete', 'Admin\ExcludeTrafficIPController@delete')->name("admin.excludetrafficip.delete");
    Route::get('admin/excludetrafficip/edit/{id}', 'Admin\ExcludeTrafficIPController@edit')->name("admin.excludetrafficip.edit");
    Route::get('admin/excludetrafficip', 'Admin\ExcludeTrafficIPController@index')->name("admin.excludetrafficip.index");






    Route::match(
        array('GET', 'POST'),
        'admin/coupon/create',
        'Admin\CouponController@create'
    )->name("admin.coupon.create");

    Route::match(
        array('GET', 'POST'),
        'admin/coupon/copycoupon',
        'Admin\CouponController@copycoupon'
    )->name("admin.coupon.copycoupon");


    Route::post('admin/coupon/deletebyuser', 'Admin\CouponController@deletebyuser')->name("admin.coupon.deletebyuser");
    Route::post('admin/coupon/editpost', 'Admin\CouponController@updatepost')->name("admin.coupon.editpost");
    Route::post('admin/coupon/createpost', 'Admin\CouponController@createpost')->name("admin.coupon.createpost");
    Route::post('admin/coupon/copypost', 'Admin\CouponController@copypost')->name("admin.coupon.copypost");
    Route::post('admin/coupon/delete', 'Admin\CouponController@delete')->name("admin.coupon.delete");
    Route::get('admin/coupon/edit/{id}', 'Admin\CouponController@edit')->name("admin.coupon.edit");
    Route::get('admin/coupon', 'Admin\CouponController@index')->name("admin.coupon.index");
    Route::get('admin/coupon/rank', 'Admin\CouponController@couponrank')->name("admin.coupon.couponrank");
    Route::get('admin/coupon/GetCouponForRank/{id}', 'Admin\CouponController@GetCouponForRank')->name("admin.coupon.getcouponforrank");
    Route::post('admin/coupon/updaterank', 'Admin\CouponController@updaterank')->name("admin.coupon.updaterank");
    Route::get('admin/coupon/homebanner', 'Admin\CouponController@homebanner')->name("admin.coupon.homebanner");
    Route::get('admin/coupon/homecoupon', 'Admin\CouponController@homecoupon')->name("admin.coupon.homecoupon");
    Route::get('admin/coupon/globaloffers', 'Admin\CouponController@globalOffers')->name("admin.coupon.globaloffers");


    Route::get('admin/homesetting/index', 'Admin\HomeSettingController@index')->name("admin.homesetting.index");
    Route::post('admin/homesetting/updatepost', 'Admin\HomeSettingController@updatepost')->name("admin.homesetting.updatepost");
    Route::get('admin/homesetting/couponrank', 'Admin\HomeSettingController@couponrank')->name("admin.homesetting.couponrank");
    Route::get('admin/homesetting/GetCouponForRank', 'Admin\HomeSettingController@GetCouponForRank')->name("admin.homesetting.getcouponforrank");
    Route::post('admin/homesetting/updaterank', 'Admin\HomeSettingController@updaterank')->name("admin.homesetting.updaterank");


    Route::get('admin/siteinfo/index', 'Admin\SiteInfoController@index')->name("admin.siteinfo.index");
    Route::post('admin/siteinfo/updatepost', 'Admin\SiteInfoController@updatepost')->name("admin.siteinfo.updatepost");

    Route::get('admin/usermessage/index', 'Admin\UserMessageController@index')->name("admin.usermessage.index");
    Route::post('admin/usermessage/delete', 'Admin\UserMessageController@delete')->name("admin.usermessage.delete");
    Route::get('admin/usermessage/getbyid/{id}', 'Admin\UserMessageController@GetById')->name("admin.usermessage.getbyid");


    Route::get('admin/subscribe/index', 'Admin\SubscribeController@index')->name("admin.subscribe.index");
    Route::post('admin/subscribe/delete', 'Admin\SubscribeController@delete')->name("admin.subscribe.delete");


    Route::post('admin/storesetting/updatepost', 'Admin\StoreSettingController@updatepost')->name("admin.storesetting.updatepost");
    Route::post('admin/storesetting/createpost', 'Admin\StoreSettingController@createpost')->name("admin.storesetting.createpost");
    // Route::get('admin/storesetting/{id}', 'Admin\StoreSettingController@show')->name("admin.storesetting.show");
    Route::get('admin/storesetting', 'Admin\StoreSettingController@index')->name("admin.storesetting.index");
    Route::post('admin/storesetting/delete', 'Admin\StoreSettingController@delete')->name("admin.storesetting.delete");
    Route::get('admin/storesetting/edit/{id}', 'Admin\StoreSettingController@edit')->name("admin.storesetting.edit");
    Route::match(
        array('GET', 'POST'),
        'admin/storesetting/create',
        'Admin\StoreSettingController@create'
    )->name("admin.storesetting.create");

    Route::get('admin/categorysetting/index', 'Admin\CategorySettingController@index')->name("admin.categorysetting.index");
    Route::post('admin/categorysetting/updatepost', 'Admin\CategorySettingController@updatepost')->name("admin.categorysetting.updatepost");

    Route::get('admin/submittedcoupon/index', 'Admin\SubmittedCouponController@index')->name("admin.submittedcoupon.index");
    Route::post('admin/submittedcoupon/delete', 'Admin\SubmittedCouponController@delete')->name("admin.submittedcoupon.delete");


    Route::get('admin/dashboard/index', 'Admin\DashboardController@index')->name("admin.dashboard.index");
    Route::get('admin/dashboard/loadVisitorsMap', 'Admin\DashboardController@loadVisitorsMap')->name("admin.dashboard.loadVisitorsMap");
    Route::get('admin/dashboard/loadVisitorsTable', 'Admin\DashboardController@loadVisitorsTable')->name("admin.dashboard.loadVisitorsTable");

    Route::get('admin/storestats/index', 'Admin\StoreStatsController@index')->name("admin.storestats.index");
});
