@extends('layouts.admin')

{{-- make the relevant menu active --}}
@section('admin_menu_icons', 'active')

{{-- display page title --}}
@section('page_title', __('Icons'))

@section('body_class', 'icons')

{{-- display page header --}}
@section('page_header_icon', 'icon-bucket')
@section('page_header', __('Icons'))

{{-- display breadcrumbs --}}
@php
    $breadcrumbs =
    [
        '' => __('Icons')
    ];
@endphp

{{-- page content --}}
@section('content')

    <?php
        $icons = array(
"icon-home" => "\\e900",
"icon-home2" => "\\e901",
"icon-home5" => "\\e904",
"icon-home7" => "\\e906",
"icon-home8" => "\\e907",
"icon-home9" => "\\e908",
"icon-office" => "\\e909",
"icon-city" => "\\e90a",
"icon-newspaper" => "\\e90b",
"icon-magazine" => "\\e90c",
"icon-design" => "\\e90d",
"icon-pencil" => "\\e90e",
"icon-pencil3" => "\\e910",
"icon-pencil4" => "\\e911",
"icon-pencil5" => "\\e912",
"icon-pencil6" => "\\e913",
"icon-pencil7" => "\\e914",
"icon-eraser" => "\\e915",
"icon-eraser2" => "\\e916",
"icon-eraser3" => "\\e917",
"icon-quill2" => "\\e919",
"icon-quill4" => "\\e91b",
"icon-pen" => "\\e91c",
"icon-pen-plus" => "\\e91d",
"icon-pen-minus" => "\\e91e",
"icon-pen2" => "\\e91f",
"icon-blog" => "\\e925",
"icon-pen6" => "\\e927",
"icon-brush" => "\\e928",
"icon-spray" => "\\e929",
"icon-color-sampler" => "\\e92c",
"icon-toggle" => "\\e92d",
"icon-bucket" => "\\e92e",
"icon-gradient" => "\\e930",
"icon-eyedropper" => "\\e931",
"icon-eyedropper2" => "\\e932",
"icon-eyedropper3" => "\\e933",
"icon-droplet" => "\\e934",
"icon-droplet2" => "\\e935",
"icon-color-clear" => "\\e937",
"icon-paint-format" => "\\e938",
"icon-stamp" => "\\e939",
"icon-image2" => "\\e93c",
"icon-image-compare" => "\\e93d",
"icon-images2" => "\\e93e",
"icon-image3" => "\\e93f",
"icon-images3" => "\\e940",
"icon-image4" => "\\e941",
"icon-image5" => "\\e942",
"icon-camera" => "\\e944",
"icon-shutter" => "\\e947",
"icon-headphones" => "\\e948",
"icon-headset" => "\\e949",
"icon-music" => "\\e94a",
"icon-album" => "\\e950",
"icon-tape" => "\\e952",
"icon-piano" => "\\e953",
"icon-speakers" => "\\e956",
"icon-play" => "\\e957",
"icon-clapboard-play" => "\\e959",
"icon-clapboard" => "\\e95a",
"icon-media" => "\\e95b",
"icon-presentation" => "\\e95c",
"icon-movie" => "\\e95d",
"icon-film" => "\\e95e",
"icon-film2" => "\\e95f",
"icon-film3" => "\\e960",
"icon-film4" => "\\e961",
"icon-video-camera" => "\\e962",
"icon-video-camera2" => "\\e963",
"icon-video-camera-slash" => "\\e964",
"icon-video-camera3" => "\\e965",
"icon-dice" => "\\e96a",
"icon-chess-king" => "\\e972",
"icon-chess-queen" => "\\e973",
"icon-chess" => "\\e978",
"icon-megaphone" => "\\e97a",
"icon-new" => "\\e97b",
"icon-connection" => "\\e97c",
"icon-station" => "\\e981",
"icon-satellite-dish2" => "\\e98a",
"icon-feed" => "\\e9b3",
"icon-mic2" => "\\e9ce",
"icon-mic-off2" => "\\e9e0",
"icon-book" => "\\e9e1",
"icon-book2" => "\\e9e9",
"icon-book-play" => "\\e9fd",
"icon-book3" => "\\ea01",
"icon-bookmark" => "\\ea02",
"icon-books" => "\\ea03",
"icon-archive" => "\\ea04",
"icon-reading" => "\\ea05",
"icon-library2" => "\\ea06",
"icon-graduation2" => "\\ea07",
"icon-file-text" => "\\ea08",
"icon-profile" => "\\ea09",
"icon-file-empty" => "\\ea0a",
"icon-file-empty2" => "\\ea0b",
"icon-files-empty" => "\\ea0c",
"icon-files-empty2" => "\\ea0d",
"icon-file-plus" => "\\ea0e",
"icon-file-plus2" => "\\ea0f",
"icon-file-minus" => "\\ea10",
"icon-file-minus2" => "\\ea11",
"icon-file-download" => "\\ea12",
"icon-file-download2" => "\\ea13",
"icon-file-upload" => "\\ea14",
"icon-file-upload2" => "\\ea15",
"icon-file-check" => "\\ea16",
"icon-file-check2" => "\\ea17",
"icon-file-eye" => "\\ea18",
"icon-file-eye2" => "\\ea19",
"icon-file-text2" => "\\ea1a",
"icon-file-text3" => "\\ea1b",
"icon-file-picture" => "\\ea1c",
"icon-file-picture2" => "\\ea1d",
"icon-file-music" => "\\ea1e",
"icon-file-music2" => "\\ea1f",
"icon-file-play" => "\\ea20",
"icon-file-play2" => "\\ea21",
"icon-file-video" => "\\ea22",
"icon-file-video2" => "\\ea23",
"icon-copy" => "\\ea24",
"icon-copy2" => "\\ea25",
"icon-file-zip" => "\\ea26",
"icon-file-zip2" => "\\ea27",
"icon-file-xml" => "\\ea28",
"icon-file-xml2" => "\\ea29",
"icon-file-css" => "\\ea2a",
"icon-file-css2" => "\\ea2b",
"icon-file-presentation" => "\\ea2c",
"icon-file-presentation2" => "\\ea2d",
"icon-file-stats" => "\\ea2e",
"icon-file-stats2" => "\\ea2f",
"icon-file-locked" => "\\ea30",
"icon-file-locked2" => "\\ea31",
"icon-file-spreadsheet" => "\\ea32",
"icon-file-spreadsheet2" => "\\ea33",
"icon-copy3" => "\\ea34",
"icon-copy4" => "\\ea35",
"icon-paste" => "\\ea36",
"icon-paste2" => "\\ea37",
"icon-paste3" => "\\ea38",
"icon-paste4" => "\\ea39",
"icon-stack" => "\\ea3a",
"icon-stack2" => "\\ea3b",
"icon-stack3" => "\\ea3c",
"icon-folder" => "\\ea3d",
"icon-folder-search" => "\\ea3e",
"icon-folder-download" => "\\ea3f",
"icon-folder-upload" => "\\ea40",
"icon-folder-plus" => "\\ea41",
"icon-folder-plus2" => "\\ea42",
"icon-folder-minus" => "\\ea43",
"icon-folder-minus2" => "\\ea44",
"icon-folder-check" => "\\ea45",
"icon-folder-heart" => "\\ea46",
"icon-folder-remove" => "\\ea47",
"icon-folder2" => "\\ea48",
"icon-folder-open" => "\\ea49",
"icon-folder3" => "\\ea4a",
"icon-folder4" => "\\ea4b",
"icon-folder-plus3" => "\\ea4c",
"icon-folder-minus3" => "\\ea4d",
"icon-folder-plus4" => "\\ea4e",
"icon-folder-minus4" => "\\ea4f",
"icon-folder-download2" => "\\ea50",
"icon-folder-upload2" => "\\ea51",
"icon-folder-download3" => "\\ea52",
"icon-folder-upload3" => "\\ea53",
"icon-folder5" => "\\ea54",
"icon-folder-open2" => "\\ea55",
"icon-folder6" => "\\ea56",
"icon-folder-open3" => "\\ea57",
"icon-certificate" => "\\ea58",
"icon-cc" => "\\ea59",
"icon-price-tag" => "\\ea5a",
"icon-price-tag2" => "\\ea5b",
"icon-price-tags" => "\\ea5c",
"icon-price-tag3" => "\\ea5d",
"icon-price-tags2" => "\\ea5e",
"icon-barcode2" => "\\ea5f",
"icon-qrcode" => "\\ea60",
"icon-ticket" => "\\ea61",
"icon-theater" => "\\ea62",
"icon-store" => "\\ea63",
"icon-store2" => "\\ea64",
"icon-cart" => "\\ea65",
"icon-cart2" => "\\ea66",
"icon-cart4" => "\\ea67",
"icon-cart5" => "\\ea68",
"icon-cart-add" => "\\ea69",
"icon-cart-add2" => "\\ea6a",
"icon-cart-remove" => "\\ea6b",
"icon-basket" => "\\ea6c",
"icon-bag" => "\\ea6d",
"icon-percent" => "\\ea6f",
"icon-coins" => "\\ea70",
"icon-coin-dollar" => "\\ea71",
"icon-coin-euro" => "\\ea72",
"icon-coin-pound" => "\\ea73",
"icon-coin-yen" => "\\ea74",
"icon-piggy-bank" => "\\ea75",
"icon-wallet" => "\\ea76",
"icon-cash" => "\\ea77",
"icon-cash2" => "\\ea78",
"icon-cash3" => "\\ea79",
"icon-cash4" => "\\ea7a",
"icon-credit-card" => "\\ea6e",
"icon-credit-card2" => "\\ea7b",
"icon-calculator4" => "\\ea7c",
"icon-calculator2" => "\\ea7d",
"icon-calculator3" => "\\ea7e",
"icon-chip" => "\\ea7f",
"icon-lifebuoy" => "\\ea80",
"icon-phone" => "\\ea81",
"icon-phone2" => "\\ea82",
"icon-phone-slash" => "\\ea83",
"icon-phone-wave" => "\\ea84",
"icon-phone-plus" => "\\ea85",
"icon-phone-minus" => "\\ea86",
"icon-phone-plus2" => "\\ea87",
"icon-phone-minus2" => "\\ea88",
"icon-phone-incoming" => "\\ea89",
"icon-phone-outgoing" => "\\ea8a",
"icon-phone-hang-up" => "\\ea8e",
"icon-address-book" => "\\ea90",
"icon-address-book2" => "\\ea91",
"icon-address-book3" => "\\ea92",
"icon-notebook" => "\\ea93",
"icon-envelop" => "\\ea94",
"icon-envelop2" => "\\ea95",
"icon-envelop3" => "\\ea96",
"icon-envelop4" => "\\ea97",
"icon-envelop5" => "\\ea98",
"icon-mailbox" => "\\ea99",
"icon-pushpin" => "\\ea9a",
"icon-location3" => "\\ea9d",
"icon-location4" => "\\ea9e",
"icon-compass4" => "\\ea9f",
"icon-map" => "\\eaa0",
"icon-map4" => "\\eaa1",
"icon-map5" => "\\eaa2",
"icon-direction" => "\\eaa3",
"icon-reset" => "\\eaa4",
"icon-history" => "\\eaa5",
"icon-watch" => "\\eaa6",
"icon-watch2" => "\\eaa7",
"icon-alarm" => "\\eaa8",
"icon-alarm-add" => "\\eaa9",
"icon-alarm-check" => "\\eaaa",
"icon-alarm-cancel" => "\\eaab",
"icon-bell2" => "\\eaac",
"icon-bell3" => "\\eaad",
"icon-bell-plus" => "\\eaae",
"icon-bell-minus" => "\\eaaf",
"icon-bell-check" => "\\eab0",
"icon-bell-cross" => "\\eab1",
"icon-calendar" => "\\eab2",
"icon-calendar2" => "\\eab3",
"icon-calendar3" => "\\eab4",
"icon-calendar52" => "\\eab6",
"icon-printer" => "\\eab7",
"icon-printer2" => "\\eab8",
"icon-printer4" => "\\eab9",
"icon-shredder" => "\\eaba",
"icon-mouse" => "\\eabb",
"icon-mouse-left" => "\\eabc",
"icon-mouse-right" => "\\eabd",
"icon-keyboard" => "\\eabe",
"icon-typewriter" => "\\eabf",
"icon-display" => "\\eac0",
"icon-display4" => "\\eac1",
"icon-laptop" => "\\eac2",
"icon-mobile" => "\\eac3",
"icon-mobile2" => "\\eac4",
"icon-tablet" => "\\eac5",
"icon-mobile3" => "\\eac6",
"icon-tv" => "\\eac7",
"icon-radio" => "\\eac8",
"icon-cabinet" => "\\eac9",
"icon-drawer" => "\\eaca",
"icon-drawer2" => "\\eacb",
"icon-drawer-out" => "\\eacc",
"icon-drawer-in" => "\\eacd",
"icon-drawer3" => "\\eace",
"icon-box" => "\\eacf",
"icon-box-add" => "\\ead0",
"icon-box-remove" => "\\ead1",
"icon-download" => "\\ead2",
"icon-upload" => "\\ead3",
"icon-floppy-disk" => "\\ead4",
"icon-floppy-disks" => "\\ead5",
"icon-usb-stick" => "\\ead6",
"icon-drive" => "\\ead7",
"icon-server" => "\\ead8",
"icon-database" => "\\ead9",
"icon-database2" => "\\eada",
"icon-database4" => "\\eadb",
"icon-database-menu" => "\\eadc",
"icon-database-add" => "\\eadd",
"icon-database-remove" => "\\eade",
"icon-database-insert" => "\\eadf",
"icon-database-export" => "\\eae0",
"icon-database-upload" => "\\eae1",
"icon-database-refresh" => "\\eae2",
"icon-database-diff" => "\\eae3",
"icon-database-edit2" => "\\eae5",
"icon-database-check" => "\\eae6",
"icon-database-arrow" => "\\eae7",
"icon-database-time2" => "\\eae9",
"icon-undo" => "\\eaea",
"icon-redo" => "\\eaeb",
"icon-rotate-ccw" => "\\eaec",
"icon-rotate-cw" => "\\eaed",
"icon-rotate-ccw2" => "\\eaee",
"icon-rotate-cw2" => "\\eaef",
"icon-rotate-ccw3" => "\\eaf0",
"icon-rotate-cw3" => "\\eaf1",
"icon-flip-vertical2" => "\\eaf2",
"icon-flip-horizontal2" => "\\eaf3",
"icon-flip-vertical3" => "\\eaf4",
"icon-flip-vertical4" => "\\eaf5",
"icon-angle" => "\\eaf6",
"icon-shear" => "\\eaf7",
"icon-align-left" => "\\eafc",
"icon-align-center-horizontal" => "\\eafd",
"icon-align-right" => "\\eafe",
"icon-align-top" => "\\eaff",
"icon-align-center-vertical" => "\\eb00",
"icon-align-bottom" => "\\eb01",
"icon-undo2" => "\\eb02",
"icon-redo2" => "\\eb03",
"icon-forward" => "\\eb04",
"icon-reply" => "\\eb05",
"icon-reply-all" => "\\eb06",
"icon-bubble" => "\\eb07",
"icon-bubbles" => "\\eb08",
"icon-bubbles2" => "\\eb09",
"icon-bubble2" => "\\eb0a",
"icon-bubbles3" => "\\eb0b",
"icon-bubbles4" => "\\eb0c",
"icon-bubble-notification" => "\\eb0d",
"icon-bubbles5" => "\\eb0e",
"icon-bubbles6" => "\\eb0f",
"icon-bubble6" => "\\eb10",
"icon-bubbles7" => "\\eb11",
"icon-bubble7" => "\\eb12",
"icon-bubbles8" => "\\eb13",
"icon-bubble8" => "\\eb14",
"icon-bubble-dots3" => "\\eb15",
"icon-bubble-lines3" => "\\eb16",
"icon-bubble9" => "\\eb17",
"icon-bubble-dots4" => "\\eb18",
"icon-bubble-lines4" => "\\eb19",
"icon-bubbles9" => "\\eb1a",
"icon-bubbles10" => "\\eb1b",
"icon-user" => "\\eb33",
"icon-users" => "\\eb34",
"icon-user-plus" => "\\eb35",
"icon-user-minus" => "\\eb36",
"icon-user-cancel" => "\\eb37",
"icon-user-block" => "\\eb38",
"icon-user-lock" => "\\eb39",
"icon-user-check" => "\\eb3a",
"icon-users2" => "\\eb3b",
"icon-users4" => "\\eb44",
"icon-user-tie" => "\\eb45",
"icon-collaboration" => "\\eb46",
"icon-vcard" => "\\eb47",
"icon-hat" => "\\ebb8",
"icon-bowtie" => "\\ebb9",
"icon-quotes-left" => "\\eb49",
"icon-quotes-right" => "\\eb4a",
"icon-quotes-left2" => "\\eb4b",
"icon-quotes-right2" => "\\eb4c",
"icon-hour-glass" => "\\eb4d",
"icon-hour-glass2" => "\\eb4e",
"icon-hour-glass3" => "\\eb4f",
"icon-spinner" => "\\eb50",
"icon-spinner2" => "\\eb51",
"icon-spinner3" => "\\eb52",
"icon-spinner4" => "\\eb53",
"icon-spinner6" => "\\eb54",
"icon-spinner9" => "\\eb55",
"icon-spinner10" => "\\eb56",
"icon-spinner11" => "\\eb57",
"icon-microscope" => "\\eb58",
"icon-enlarge" => "\\eb59",
"icon-shrink" => "\\eb5a",
"icon-enlarge3" => "\\eb5b",
"icon-shrink3" => "\\eb5c",
"icon-enlarge5" => "\\eb5d",
"icon-shrink5" => "\\eb5e",
"icon-enlarge6" => "\\eb5f",
"icon-shrink6" => "\\eb60",
"icon-enlarge7" => "\\eb61",
"icon-shrink7" => "\\eb62",
"icon-key" => "\\eb63",
"icon-lock" => "\\eb65",
"icon-lock2" => "\\eb66",
"icon-lock4" => "\\eb67",
"icon-unlocked" => "\\eb68",
"icon-lock5" => "\\eb69",
"icon-unlocked2" => "\\eb6a",
"icon-safe" => "\\eb6b",
"icon-wrench" => "\\eb6c",
"icon-wrench2" => "\\eb6d",
"icon-wrench3" => "\\eb6e",
"icon-equalizer" => "\\eb6f",
"icon-equalizer2" => "\\eb70",
"icon-equalizer3" => "\\eb71",
"icon-equalizer4" => "\\eb72",
"icon-cog" => "\\eb73",
"icon-cogs" => "\\eb74",
"icon-cog2" => "\\eb75",
"icon-cog3" => "\\eb76",
"icon-cog4" => "\\eb77",
"icon-cog52" => "\\eb78",
"icon-cog6" => "\\eb79",
"icon-cog7" => "\\eb7a",
"icon-hammer" => "\\eb7c",
"icon-hammer-wrench" => "\\eb7d",
"icon-magic-wand" => "\\eb7e",
"icon-magic-wand2" => "\\eb7f",
"icon-pulse2" => "\\eb80",
"icon-aid-kit" => "\\eb81",
"icon-bug2" => "\\eb83",
"icon-construction" => "\\eb85",
"icon-traffic-cone" => "\\eb86",
"icon-traffic-lights" => "\\eb87",
"icon-pie-chart" => "\\eb88",
"icon-pie-chart2" => "\\eb89",
"icon-pie-chart3" => "\\eb8a",
"icon-pie-chart4" => "\\eb8b",
"icon-pie-chart5" => "\\eb8c",
"icon-pie-chart6" => "\\eb8d",
"icon-pie-chart7" => "\\eb8e",
"icon-stats-dots" => "\\eb8f",
"icon-stats-bars" => "\\eb90",
"icon-pie-chart8" => "\\eb91",
"icon-stats-bars2" => "\\eb92",
"icon-stats-bars3" => "\\eb93",
"icon-stats-bars4" => "\\eb94",
"icon-chart" => "\\eb97",
"icon-stats-growth" => "\\eb98",
"icon-stats-decline" => "\\eb99",
"icon-stats-growth2" => "\\eb9a",
"icon-stats-decline2" => "\\eb9b",
"icon-stairs-up" => "\\eb9c",
"icon-stairs-down" => "\\eb9d",
"icon-stairs" => "\\eb9e",
"icon-ladder" => "\\eba0",
"icon-rating" => "\\eba1",
"icon-rating2" => "\\eba2",
"icon-rating3" => "\\eba3",
"icon-podium" => "\\eba5",
"icon-stars" => "\\eba6",
"icon-medal-star" => "\\eba7",
"icon-medal" => "\\eba8",
"icon-medal2" => "\\eba9",
"icon-medal-first" => "\\ebaa",
"icon-medal-second" => "\\ebab",
"icon-medal-third" => "\\ebac",
"icon-crown" => "\\ebad",
"icon-trophy2" => "\\ebaf",
"icon-trophy3" => "\\ebb0",
"icon-diamond" => "\\ebb1",
"icon-trophy4" => "\\ebb2",
"icon-gift" => "\\ebb3",
"icon-pipe" => "\\ebb6",
"icon-mustache" => "\\ebb7",
"icon-cup2" => "\\ebc6",
"icon-coffee" => "\\ebc8",
"icon-paw" => "\\ebd5",
"icon-footprint" => "\\ebd6",
"icon-rocket" => "\\ebda",
"icon-meter2" => "\\ebdc",
"icon-meter-slow" => "\\ebdd",
"icon-meter-fast" => "\\ebdf",
"icon-hammer2" => "\\ebe1",
"icon-balance" => "\\ebe2",
"icon-fire" => "\\ebe5",
"icon-fire2" => "\\ebe6",
"icon-lab" => "\\ebe7",
"icon-atom" => "\\ebe8",
"icon-atom2" => "\\ebe9",
"icon-bin" => "\\ebfa",
"icon-bin2" => "\\ebfb",
"icon-briefcase" => "\\ebff",
"icon-briefcase3" => "\\ec01",
"icon-airplane2" => "\\ec03",
"icon-airplane3" => "\\ec04",
"icon-airplane4" => "\\ec05",
"icon-paperplane" => "\\ec06",
"icon-car" => "\\ec07",
"icon-steering-wheel" => "\\ec08",
"icon-car2" => "\\ec09",
"icon-gas" => "\\ec0a",
"icon-bus" => "\\ec0b",
"icon-truck" => "\\ec0c",
"icon-bike" => "\\ec0d",
"icon-road" => "\\ec0e",
"icon-train" => "\\ec0f",
"icon-train2" => "\\ec10",
"icon-ship" => "\\ec11",
"icon-boat" => "\\ec12",
"icon-chopper" => "\\ec13",
"icon-cube" => "\\ec15",
"icon-cube2" => "\\ec16",
"icon-cube3" => "\\ec17",
"icon-cube4" => "\\ec18",
"icon-pyramid" => "\\ec19",
"icon-pyramid2" => "\\ec1a",
"icon-package" => "\\ec1b",
"icon-puzzle" => "\\ec1c",
"icon-puzzle2" => "\\ec1d",
"icon-puzzle3" => "\\ec1e",
"icon-puzzle4" => "\\ec1f",
"icon-glasses-3d2" => "\\ec21",
"icon-brain" => "\\ec24",
"icon-accessibility" => "\\ec25",
"icon-accessibility2" => "\\ec26",
"icon-strategy" => "\\ec27",
"icon-target" => "\\ec28",
"icon-target2" => "\\ec29",
"icon-shield-check" => "\\ec2f",
"icon-shield-notice" => "\\ec30",
"icon-shield2" => "\\ec31",
"icon-racing" => "\\ec40",
"icon-finish" => "\\ec41",
"icon-power2" => "\\ec46",
"icon-power3" => "\\ec47",
"icon-switch" => "\\ec48",
"icon-switch22" => "\\ec49",
"icon-power-cord" => "\\ec4a",
"icon-clipboard" => "\\ec4d",
"icon-clipboard2" => "\\ec4e",
"icon-clipboard3" => "\\ec4f",
"icon-clipboard4" => "\\ec50",
"icon-clipboard5" => "\\ec51",
"icon-clipboard6" => "\\ec52",
"icon-playlist" => "\\ec53",
"icon-playlist-add" => "\\ec54",
"icon-list-numbered" => "\\ec55",
"icon-list" => "\\ec56",
"icon-list2" => "\\ec57",
"icon-more" => "\\ec58",
"icon-more2" => "\\ec59",
"icon-grid" => "\\ec5a",
"icon-grid2" => "\\ec5b",
"icon-grid3" => "\\ec5c",
"icon-grid4" => "\\ec5d",
"icon-grid52" => "\\ec5e",
"icon-grid6" => "\\ec5f",
"icon-grid7" => "\\ec60",
"icon-tree5" => "\\ec61",
"icon-tree6" => "\\ec62",
"icon-tree7" => "\\ec63",
"icon-lan" => "\\ec64",
"icon-lan2" => "\\ec65",
"icon-lan3" => "\\ec66",
"icon-menu" => "\\ec67",
"icon-circle-small" => "\\ec68",
"icon-menu2" => "\\ec69",
"icon-menu3" => "\\ec6a",
"icon-menu4" => "\\ec6b",
"icon-menu5" => "\\ec6c",
"icon-menu62" => "\\ec6d",
"icon-menu7" => "\\ec6e",
"icon-menu8" => "\\ec6f",
"icon-menu9" => "\\ec70",
"icon-menu10" => "\\ec71",
"icon-cloud" => "\\ec72",
"icon-cloud-download" => "\\ec73",
"icon-cloud-upload" => "\\ec74",
"icon-cloud-check" => "\\ec75",
"icon-cloud2" => "\\ec76",
"icon-cloud-download2" => "\\ec77",
"icon-cloud-upload2" => "\\ec78",
"icon-cloud-check2" => "\\ec79",
"icon-import" => "\\ec7e",
"icon-download4" => "\\ec80",
"icon-upload4" => "\\ec81",
"icon-download7" => "\\ec86",
"icon-upload7" => "\\ec87",
"icon-download10" => "\\ec8c",
"icon-upload10" => "\\ec8d",
"icon-sphere" => "\\ec8e",
"icon-sphere3" => "\\ec90",
"icon-earth" => "\\ec93",
"icon-link" => "\\ec96",
"icon-unlink" => "\\ec97",
"icon-link2" => "\\ec98",
"icon-unlink2" => "\\ec99",
"icon-anchor" => "\\eca0",
"icon-flag3" => "\\eca3",
"icon-flag4" => "\\eca4",
"icon-flag7" => "\\eca7",
"icon-flag8" => "\\eca8",
"icon-attachment" => "\\eca9",
"icon-attachment2" => "\\ecaa",
"icon-eye" => "\\ecab",
"icon-eye-plus" => "\\ecac",
"icon-eye-minus" => "\\ecad",
"icon-eye-blocked" => "\\ecae",
"icon-eye2" => "\\ecaf",
"icon-eye-blocked2" => "\\ecb0",
"icon-eye4" => "\\ecb3",
"icon-bookmark2" => "\\ecb4",
"icon-bookmark3" => "\\ecb5",
"icon-bookmarks" => "\\ecb6",
"icon-bookmark4" => "\\ecb7",
"icon-spotlight2" => "\\ecb8",
"icon-starburst" => "\\ecb9",
"icon-snowflake" => "\\ecba",
"icon-weather-windy" => "\\ecd0",
"icon-fan" => "\\ecd1",
"icon-umbrella" => "\\ecd2",
"icon-sun3" => "\\ecd3",
"icon-contrast" => "\\ecd4",
"icon-bed2" => "\\ecda",
"icon-furniture" => "\\ecdb",
"icon-chair" => "\\ecdc",
"icon-star-empty3" => "\\ece0",
"icon-star-half" => "\\ece1",
"icon-star-full2" => "\\ece2",
"icon-heart5" => "\\ece9",
"icon-heart6" => "\\ecea",
"icon-heart-broken2" => "\\eceb",
"icon-thumbs-up2" => "\\ecf2",
"icon-thumbs-down2" => "\\ecf4",
"icon-thumbs-up3" => "\\ecf5",
"icon-thumbs-down3" => "\\ecf6",
"icon-height" => "\\ecf7",
"icon-man" => "\\ecf8",
"icon-woman" => "\\ecf9",
"icon-man-woman" => "\\ecfa",
"icon-yin-yang" => "\\ecfe",
"icon-cursor" => "\\ed23",
"icon-cursor2" => "\\ed24",
"icon-lasso2" => "\\ed26",
"icon-select2" => "\\ed28",
"icon-point-up" => "\\ed29",
"icon-point-right" => "\\ed2a",
"icon-point-down" => "\\ed2b",
"icon-point-left" => "\\ed2c",
"icon-pointer" => "\\ed2d",
"icon-reminder" => "\\ed2e",
"icon-drag-left-right" => "\\ed2f",
"icon-drag-left" => "\\ed30",
"icon-drag-right" => "\\ed31",
"icon-touch" => "\\ed32",
"icon-multitouch" => "\\ed33",
"icon-touch-zoom" => "\\ed34",
"icon-touch-pinch" => "\\ed35",
"icon-hand" => "\\ed36",
"icon-grab" => "\\ed37",
"icon-stack-empty" => "\\ed38",
"icon-stack-plus" => "\\ed39",
"icon-stack-minus" => "\\ed3a",
"icon-stack-star" => "\\ed3b",
"icon-stack-picture" => "\\ed3c",
"icon-stack-down" => "\\ed3d",
"icon-stack-up" => "\\ed3e",
"icon-stack-cancel" => "\\ed3f",
"icon-stack-check" => "\\ed40",
"icon-stack-text" => "\\ed41",
"icon-stack4" => "\\ed47",
"icon-stack-music" => "\\ed48",
"icon-stack-play" => "\\ed49",
"icon-move" => "\\ed4a",
"icon-dots" => "\\ed4b",
"icon-warning" => "\\ed4c",
"icon-warning22" => "\\ed4d",
"icon-notification2" => "\\ed4f",
"icon-question3" => "\\ed52",
"icon-question4" => "\\ed53",
"icon-plus3" => "\\ed5a",
"icon-minus3" => "\\ed5b",
"icon-plus-circle2" => "\\ed5e",
"icon-minus-circle2" => "\\ed5f",
"icon-cancel-circle2" => "\\ed63",
"icon-blocked" => "\\ed64",
"icon-cancel-square" => "\\ed65",
"icon-cancel-square2" => "\\ed66",
"icon-spam" => "\\ed68",
"icon-cross2" => "\\ed6a",
"icon-cross3" => "\\ed6b",
"icon-checkmark" => "\\ed6c",
"icon-checkmark3" => "\\ed6e",
"icon-checkmark2" => "\\e372",
"icon-checkmark4" => "\\ed6f",
"icon-spell-check" => "\\ed71",
"icon-spell-check2" => "\\ed72",
"icon-enter" => "\\ed73",
"icon-exit" => "\\ed74",
"icon-enter2" => "\\ed75",
"icon-exit2" => "\\ed76",
"icon-enter3" => "\\ed77",
"icon-exit3" => "\\ed78",
"icon-wall" => "\\ed79",
"icon-fence" => "\\ed7a",
"icon-play3" => "\\ed7b",
"icon-pause" => "\\ed7c",
"icon-stop" => "\\ed7d",
"icon-previous" => "\\ed7e",
"icon-next" => "\\ed7f",
"icon-backward" => "\\ed80",
"icon-forward2" => "\\ed81",
"icon-play4" => "\\ed82",
"icon-pause2" => "\\ed83",
"icon-stop2" => "\\ed84",
"icon-backward2" => "\\ed85",
"icon-forward3" => "\\ed86",
"icon-first" => "\\ed87",
"icon-last" => "\\ed88",
"icon-previous2" => "\\ed89",
"icon-next2" => "\\ed8a",
"icon-eject" => "\\ed8b",
"icon-volume-high" => "\\ed8c",
"icon-volume-medium" => "\\ed8d",
"icon-volume-low" => "\\ed8e",
"icon-volume-mute" => "\\ed8f",
"icon-speaker-left" => "\\ed90",
"icon-speaker-right" => "\\ed91",
"icon-volume-mute2" => "\\ed92",
"icon-volume-increase" => "\\ed93",
"icon-volume-decrease" => "\\ed94",
"icon-volume-mute5" => "\\eda4",
"icon-loop" => "\\eda5",
"icon-loop3" => "\\eda7",
"icon-infinite-square" => "\\eda8",
"icon-infinite" => "\\eda9",
"icon-loop4" => "\\edab",
"icon-shuffle" => "\\edac",
"icon-wave" => "\\edae",
"icon-wave2" => "\\edaf",
"icon-split" => "\\edb0",
"icon-merge" => "\\edb1",
"icon-arrow-up5" => "\\edc4",
"icon-arrow-right5" => "\\edc5",
"icon-arrow-down5" => "\\edc6",
"icon-arrow-left5" => "\\edc7",
"icon-arrow-up-left2" => "\\edd0",
"icon-arrow-up7" => "\\edd1",
"icon-arrow-up-right2" => "\\edd2",
"icon-arrow-right7" => "\\edd3",
"icon-arrow-down-right2" => "\\edd4",
"icon-arrow-down7" => "\\edd5",
"icon-arrow-down-left2" => "\\edd6",
"icon-arrow-left7" => "\\edd7",
"icon-arrow-up-left3" => "\\edd8",
"icon-arrow-up8" => "\\edd9",
"icon-arrow-up-right3" => "\\edda",
"icon-arrow-right8" => "\\eddb",
"icon-arrow-down-right3" => "\\eddc",
"icon-arrow-down8" => "\\eddd",
"icon-arrow-down-left3" => "\\edde",
"icon-arrow-left8" => "\\eddf",
"icon-circle-up2" => "\\ede4",
"icon-circle-right2" => "\\ede5",
"icon-circle-down2" => "\\ede6",
"icon-circle-left2" => "\\ede7",
"icon-arrow-resize7" => "\\edfe",
"icon-arrow-resize8" => "\\edff",
"icon-square-up-left" => "\\ee00",
"icon-square-up" => "\\ee01",
"icon-square-up-right" => "\\ee02",
"icon-square-right" => "\\ee03",
"icon-square-down-right" => "\\ee04",
"icon-square-down" => "\\ee05",
"icon-square-down-left" => "\\ee06",
"icon-square-left" => "\\ee07",
"icon-arrow-up15" => "\\ee30",
"icon-arrow-right15" => "\\ee31",
"icon-arrow-down15" => "\\ee32",
"icon-arrow-left15" => "\\ee33",
"icon-arrow-up16" => "\\ee34",
"icon-arrow-right16" => "\\ee35",
"icon-arrow-down16" => "\\ee36",
"icon-arrow-left16" => "\\ee37",
"icon-menu-open" => "\\ee38",
"icon-menu-open2" => "\\ee39",
"icon-menu-close" => "\\ee3a",
"icon-menu-close2" => "\\ee3b",
"icon-enter5" => "\\ee3d",
"icon-esc" => "\\ee3e",
"icon-enter6" => "\\ee3f",
"icon-backspace" => "\\ee40",
"icon-backspace2" => "\\ee41",
"icon-tab" => "\\ee42",
"icon-transmission" => "\\ee43",
"icon-sort" => "\\ee45",
"icon-move-up2" => "\\ee47",
"icon-move-down2" => "\\ee48",
"icon-sort-alpha-asc" => "\\ee49",
"icon-sort-alpha-desc" => "\\ee4a",
"icon-sort-numeric-asc" => "\\ee4b",
"icon-sort-numberic-desc" => "\\ee4c",
"icon-sort-amount-asc" => "\\ee4d",
"icon-sort-amount-desc" => "\\ee4e",
"icon-sort-time-asc" => "\\ee4f",
"icon-sort-time-desc" => "\\ee50",
"icon-battery-6" => "\\ee51",
"icon-battery-0" => "\\ee57",
"icon-battery-charging" => "\\ee58",
"icon-command" => "\\ee5f",
"icon-shift" => "\\ee60",
"icon-ctrl" => "\\ee61",
"icon-opt" => "\\ee62",
"icon-checkbox-checked" => "\\ee63",
"icon-checkbox-unchecked" => "\\ee64",
"icon-checkbox-partial" => "\\ee65",
"icon-square" => "\\ee66",
"icon-triangle" => "\\ee67",
"icon-triangle2" => "\\ee68",
"icon-diamond3" => "\\ee69",
"icon-diamond4" => "\\ee6a",
"icon-checkbox-checked2" => "\\ee6b",
"icon-checkbox-unchecked2" => "\\ee6c",
"icon-checkbox-partial2" => "\\ee6d",
"icon-radio-checked" => "\\ee6e",
"icon-radio-checked2" => "\\ee6f",
"icon-radio-unchecked" => "\\ee70",
"icon-checkmark-circle" => "\\ee73",
"icon-circle" => "\\ee74",
"icon-circle2" => "\\ee75",
"icon-circles" => "\\ee76",
"icon-circles2" => "\\ee77",
"icon-crop" => "\\ee78",
"icon-crop2" => "\\ee79",
"icon-make-group" => "\\ee7a",
"icon-ungroup" => "\\ee7b",
"icon-vector" => "\\ee7c",
"icon-vector2" => "\\ee7d",
"icon-rulers" => "\\ee7e",
"icon-pencil-ruler" => "\\ee80",
"icon-scissors" => "\\ee81",
"icon-filter3" => "\\ee88",
"icon-filter4" => "\\ee89",
"icon-font" => "\\ee8a",
"icon-ampersand2" => "\\ee8b",
"icon-ligature" => "\\ee8c",
"icon-font-size" => "\\ee8e",
"icon-typography" => "\\ee8f",
"icon-text-height" => "\\ee90",
"icon-text-width" => "\\ee91",
"icon-height2" => "\\ee92",
"icon-width" => "\\ee93",
"icon-strikethrough2" => "\\ee98",
"icon-font-size2" => "\\ee99",
"icon-bold2" => "\\ee9a",
"icon-underline2" => "\\ee9b",
"icon-italic2" => "\\ee9c",
"icon-strikethrough3" => "\\ee9d",
"icon-omega" => "\\ee9e",
"icon-sigma" => "\\ee9f",
"icon-nbsp" => "\\eea0",
"icon-page-break" => "\\eea1",
"icon-page-break2" => "\\eea2",
"icon-superscript" => "\\eea3",
"icon-subscript" => "\\eea4",
"icon-superscript2" => "\\eea5",
"icon-subscript2" => "\\eea6",
"icon-text-color" => "\\eea7",
"icon-highlight" => "\\eea8",
"icon-pagebreak" => "\\eea9",
"icon-clear-formatting" => "\\eeaa",
"icon-table" => "\\eeab",
"icon-table2" => "\\eeac",
"icon-insert-template" => "\\eead",
"icon-pilcrow" => "\\eeae",
"icon-ltr" => "\\eeaf",
"icon-rtl" => "\\eeb0",
"icon-ltr2" => "\\eeb1",
"icon-rtl2" => "\\eeb2",
"icon-section" => "\\eeb3",
"icon-paragraph-left2" => "\\eeb8",
"icon-paragraph-center2" => "\\eeb9",
"icon-paragraph-right2" => "\\eeba",
"icon-paragraph-justify2" => "\\eebb",
"icon-indent-increase" => "\\eebc",
"icon-indent-decrease" => "\\eebd",
"icon-paragraph-left3" => "\\eebe",
"icon-paragraph-center3" => "\\eebf",
"icon-paragraph-right3" => "\\eec0",
"icon-paragraph-justify3" => "\\eec1",
"icon-indent-increase2" => "\\eec2",
"icon-indent-decrease2" => "\\eec3",
"icon-share" => "\\eec4",
"icon-share2" => "\\eec5",
"icon-new-tab" => "\\eec6",
"icon-new-tab2" => "\\eec7",
"icon-popout" => "\\eec8",
"icon-embed" => "\\eec9",
"icon-embed2" => "\\eeca",
"icon-markup" => "\\eecb",
"icon-regexp" => "\\eecc",
"icon-regexp2" => "\\eecd",
"icon-code" => "\\eece",
"icon-circle-css" => "\\eecf",
"icon-circle-code" => "\\eed0",
"icon-terminal" => "\\eed1",
"icon-unicode" => "\\eed2",
"icon-seven-segment-0" => "\\eed3",
"icon-seven-segment-1" => "\\eed4",
"icon-seven-segment-2" => "\\eed5",
"icon-seven-segment-3" => "\\eed6",
"icon-seven-segment-4" => "\\eed7",
"icon-seven-segment-5" => "\\eed8",
"icon-seven-segment-6" => "\\eed9",
"icon-seven-segment-7" => "\\eeda",
"icon-seven-segment-8" => "\\eedb",
"icon-seven-segment-9" => "\\eedc",
"icon-share3" => "\\eedd",
"icon-share4" => "\\eede",
"icon-google" => "\\eee3",
"icon-google-plus" => "\\eee4",
"icon-google-plus2" => "\\eee5",
"icon-google-drive" => "\\eee7",
"icon-facebook" => "\\eee8",
"icon-facebook2" => "\\eee9",
"icon-instagram" => "\\eeec",
"icon-twitter" => "\\eeed",
"icon-twitter2" => "\\eeee",
"icon-feed2" => "\\eef0",
"icon-feed3" => "\\eef1",
"icon-youtube" => "\\eef3",
"icon-youtube2" => "\\eef4",
"icon-youtube3" => "\\eef5",
"icon-vimeo" => "\\eef8",
"icon-vimeo2" => "\\eef9",
"icon-lanyrd" => "\\eefb",
"icon-flickr" => "\\eefc",
"icon-flickr2" => "\\eefd",
"icon-flickr3" => "\\eefe",
"icon-picassa" => "\\ef00",
"icon-picassa2" => "\\ef01",
"icon-dribbble" => "\\ef02",
"icon-dribbble2" => "\\ef03",
"icon-dribbble3" => "\\ef04",
"icon-forrst" => "\\ef05",
"icon-forrst2" => "\\ef06",
"icon-deviantart" => "\\ef07",
"icon-deviantart2" => "\\ef08",
"icon-steam" => "\\ef09",
"icon-steam2" => "\\ef0a",
"icon-dropbox" => "\\ef0b",
"icon-onedrive" => "\\ef0c",
"icon-github" => "\\ef0d",
"icon-github4" => "\\ef10",
"icon-github5" => "\\ef11",
"icon-wordpress" => "\\ef12",
"icon-wordpress2" => "\\ef13",
"icon-joomla" => "\\ef14",
"icon-blogger" => "\\ef15",
"icon-blogger2" => "\\ef16",
"icon-tumblr" => "\\ef17",
"icon-tumblr2" => "\\ef18",
"icon-yahoo" => "\\ef19",
"icon-tux" => "\\ef1a",
"icon-apple2" => "\\ef1b",
"icon-finder" => "\\ef1c",
"icon-android" => "\\ef1d",
"icon-windows" => "\\ef1e",
"icon-windows8" => "\\ef1f",
"icon-soundcloud" => "\\ef20",
"icon-soundcloud2" => "\\ef21",
"icon-skype" => "\\ef22",
"icon-reddit" => "\\ef23",
"icon-linkedin" => "\\ef24",
"icon-linkedin2" => "\\ef25",
"icon-lastfm" => "\\ef26",
"icon-lastfm2" => "\\ef27",
"icon-delicious" => "\\ef28",
"icon-stumbleupon" => "\\ef29",
"icon-stumbleupon2" => "\\ef2a",
"icon-stackoverflow" => "\\ef2b",
"icon-pinterest2" => "\\ef2d",
"icon-xing" => "\\ef2e",
"icon-flattr" => "\\ef30",
"icon-foursquare" => "\\ef31",
"icon-paypal" => "\\ef32",
"icon-paypal2" => "\\ef33",
"icon-yelp" => "\\ef35",
"icon-file-pdf" => "\\ef36",
"icon-file-openoffice" => "\\ef37",
"icon-file-word" => "\\ef38",
"icon-file-excel" => "\\ef39",
"icon-libreoffice" => "\\ef3a",
"icon-html5" => "\\ef3b",
"icon-html52" => "\\ef3c",
"icon-css3" => "\\ef3d",
"icon-git" => "\\ef3e",
"icon-svg" => "\\ef3f",
"icon-codepen" => "\\ef40",
"icon-chrome" => "\\ef41",
"icon-firefox" => "\\ef42",
"icon-IE" => "\\ef43",
"icon-opera" => "\\ef44",
"icon-safari" => "\\ef45",
"icon-check2" => "\\e601",
"icon-home4" => "\\e603",
"icon-people" => "\\e81b",
"icon-checkmark-circle2" => "\\e853",
"icon-arrow-up-left32" => "\\e8ae",
"icon-arrow-up52" => "\\e8af",
"icon-arrow-up-right32" => "\\e8b0",
"icon-arrow-right6" => "\\e8b1",
"icon-arrow-down-right32" => "\\e8b2",
"icon-arrow-down52" => "\\e8b3",
"icon-arrow-down-left32" => "\\e8b4",
"icon-arrow-left52" => "\\e8b5",
"icon-calendar5" => "\\e985",
"icon-move-alt1" => "\\e986",
"icon-reload-alt" => "\\e987",
"icon-move-vertical" => "\\e988",
"icon-move-horizontal" => "\\e989",
"icon-hash" => "\\e98b",
"icon-bars-alt" => "\\e98c",
"icon-eye8" => "\\e98d",
"icon-search4" => "\\e98e",
"icon-zoomin3" => "\\e98f",
"icon-zoomout3" => "\\e990",
"icon-add" => "\\e991",
"icon-subtract" => "\\e992",
"icon-exclamation" => "\\e993",
"icon-question6" => "\\e994",
"icon-close2" => "\\e995",
"icon-task" => "\\e996",
"icon-inbox" => "\\e997",
"icon-inbox-alt" => "\\e998",
"icon-envelope" => "\\e999",
"icon-compose" => "\\e99a",
"icon-newspaper2" => "\\e99b",
"icon-calendar22" => "\\e99c",
"icon-hyperlink" => "\\e99d",
"icon-trash" => "\\e99e",
"icon-trash-alt" => "\\e99f",
"icon-grid5" => "\\e9a0",
"icon-grid-alt" => "\\e9a1",
"icon-menu6" => "\\e9a2",
"icon-list3" => "\\e9a3",
"icon-gallery" => "\\e9a4",
"icon-calculator" => "\\e9a5",
"icon-windows2" => "\\e9a6",
"icon-browser" => "\\e9a7",
"icon-portfolio" => "\\e9a8",
"icon-comments" => "\\e9a9",
"icon-screen3" => "\\e9aa",
"icon-iphone" => "\\e9ab",
"icon-ipad" => "\\e9ac",
"icon-googleplus5" => "\\e9ad",
"icon-pin" => "\\e9ae",
"icon-pin-alt" => "\\e9af",
"icon-cog5" => "\\e9b0",
"icon-graduation" => "\\e9b1",
"icon-air" => "\\e9b2",
"icon-droplets" => "\\e7ee",
"icon-statistics" => "\\e9b4",
"icon-pie5" => "\\e7ef",
"icon-cross" => "\\e9b6",
"icon-minus2" => "\\e9b7",
"icon-plus2" => "\\e9b8",
"icon-info3" => "\\e9b9",
"icon-info22" => "\\e9ba",
"icon-question7" => "\\e9bb",
"icon-help" => "\\e9bc",
"icon-warning2" => "\\e9bd",
"icon-add-to-list" => "\\e9bf",
"icon-arrow-left12" => "\\e9c0",
"icon-arrow-down12" => "\\e9c1",
"icon-arrow-up12" => "\\e9c2",
"icon-arrow-right13" => "\\e9c3",
"icon-arrow-left22" => "\\e9c4",
"icon-arrow-down22" => "\\e9c5",
"icon-arrow-up22" => "\\e9c6",
"icon-arrow-right22" => "\\e9c7",
"icon-arrow-left32" => "\\e9c8",
"icon-arrow-down32" => "\\e9c9",
"icon-arrow-up32" => "\\e9ca",
"icon-arrow-right32" => "\\e9cb",
"icon-switch2" => "\\e647",
"icon-checkmark5" => "\\e600",
"icon-ampersand" => "\\e9cc",
"icon-alert" => "\\e9cf",
"icon-alignment-align" => "\\e9d0",
"icon-alignment-aligned-to" => "\\e9d1",
"icon-alignment-unalign" => "\\e9d2",
"icon-arrow-down132" => "\\e9d3",
"icon-arrow-up13" => "\\e9da",
"icon-arrow-left13" => "\\e9d4",
"icon-arrow-right14" => "\\e9d5",
"icon-arrow-small-down" => "\\e9d6",
"icon-arrow-small-left" => "\\e9d7",
"icon-arrow-small-right" => "\\e9d8",
"icon-arrow-small-up" => "\\e9d9",
"icon-check" => "\\e9db",
"icon-chevron-down" => "\\e9dc",
"icon-chevron-left" => "\\e9dd",
"icon-chevron-right" => "\\e9de",
"icon-chevron-up" => "\\e9df",
"icon-clippy" => "\\f035",
"icon-comment" => "\\f02b",
"icon-comment-discussion" => "\\f04f",
"icon-dash" => "\\e9e2",
"icon-diff" => "\\e9e3",
"icon-diff-added" => "\\e9e4",
"icon-diff-ignored" => "\\e9e5",
"icon-diff-modified" => "\\e9e6",
"icon-diff-removed" => "\\e9e7",
"icon-diff-renamed" => "\\e9e8",
"icon-file-media" => "\\f012",
"icon-fold" => "\\e9ea",
"icon-gear" => "\\e9eb",
"icon-git-branch" => "\\e9ec",
"icon-git-commit" => "\\e9ed",
"icon-git-compare" => "\\e9ee",
"icon-git-merge" => "\\e9ef",
"icon-git-pull-request" => "\\e9f0",
"icon-graph" => "\\f043",
"icon-law" => "\\e9f1",
"icon-list-ordered" => "\\e9f2",
"icon-list-unordered" => "\\e9f3",
"icon-mail5" => "\\e9f4",
"icon-mail-read" => "\\e9f5",
"icon-mention" => "\\e9f6",
"icon-mirror" => "\\f024",
"icon-move-down" => "\\f0a8",
"icon-move-left" => "\\f074",
"icon-move-right" => "\\f0a9",
"icon-move-up" => "\\f0a7",
"icon-person" => "\\f018",
"icon-plus22" => "\\e9f7",
"icon-primitive-dot" => "\\f052",
"icon-primitive-square" => "\\f053",
"icon-repo-forked" => "\\e9f8",
"icon-screen-full" => "\\e9f9",
"icon-screen-normal" => "\\e9fa",
"icon-sync" => "\\e9fb",
"icon-three-bars" => "\\e9fc",
"icon-unfold" => "\\e9fe",
"icon-versions" => "\\e9ff",
"icon-x" => "\\ea00",
);
    ?>

    <div class="row">
        @foreach ($icons as $icon_class => $icon_glyph)
            <div class="col-sm-2 text-center">
                <div class="py-4 mb-1">
                    <i class="icon-2x {{ $icon_class }}" aria-hidden="true"></i>
                    <p class="mb-0 mt-1 text-dark small" title="Icon Class"><span class="selectable">{{ $icon_class }}</span></p>
                    <p class="mb-0 text-secondary small" title="Icon Glyph"><span class="selectable">{{ $icon_glyph }}</span></p>
                </div>
            </div>
        @endforeach
    </div>

@endsection
