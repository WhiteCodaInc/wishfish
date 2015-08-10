/* globals hopscotch: false */

/* ============ */
/* EXAMPLE TOUR */
/* ============ */

var tour = {
    id: 'welcome',
    steps: [
        {
            target: 'center',
            title: 'Add a Contact',
            placement: 'top',
            xOffset: 'center',
            arrowOffset: 'center'
        },
        {
            target: 'center',
            title: 'Setup a birthday reminder',
            placement: 'top',
            xOffset: 'center',
            arrowOffset: 'center',
            showPrevButton: false
        },
        {
            target: 'center',
            title: 'Explore & Enjoy',
            placement: 'top',
            xOffset: 'center',
            arrowOffset: 'center',
            showPrevButton: false
        },
        {
            target: 'wishfish-title',
            title: 'Welcome to Wish-Fish!',
            content: "If this is your first time here, click 'next' and we will show you around!",
            placement: 'left',
            showPrevButton: false,
            onNext: function () {
                $('ul.navbar-right li.user-menu').addClass('open');
            }
        },
        {
//      target: document.querySelectorAll('#general-use-desc code')[1],
            target: 'wishfish-profile',
            title: 'Setup Your Profile',
//      content: '',
            placement: 'left',
            yOffset: 'center',
            delay: 50,
            showNextButton: false,
            showPrevButton: false,
            multipage: true,
            onNext: function () {
//                window.location = "https://wish-fish.com/app/profile";
            }
        },
        {
            target: 'profile-pic',
            showPrevButton: false,
            placement: 'left',
            yOffset: 'center',
            arrowOffset: 20,
            title: 'Add Profile Picture'

        },
        {
            target: 'full-name',
            title: 'Enter Your Name',
            showPrevButton: false,
            //content: '',
            placement: 'left',
            yOffset: 'center',
            arrowOffset: 30,
            onPrev: function () {
                window.location = "https://wish-fish.com/app/dashboard";
            }
        },
        {
            target: 'phone-number',
            showPrevButton: false,
            placement: 'left',
            yOffset: 'center',
            title: 'Add Your Phone Number',
            arrowOffset: 30
        },
        {
            target: 'birthday',
            showPrevButton: false,
            placement: 'left',
            yOffset: 'center',
            title: 'Enter Your Birthday',
            arrowOffset: 30
        },
        {
            target: 'select-timezone',
            showPrevButton: false,
            placement: 'left',
            yOffset: -60,
            title: 'Select Your Time Zone',
            arrowOffset: 30,
        },
        {
            target: 'save-profile',
            showPrevButton: false,
            showNextButton: false,
            placement: 'bottom',
//            yOffset: 'center',
            title: 'Save Your Profile',
//            arrowOffset: 10,
            multipage: true
        },
        {
            target: 'wishfish-contact',
            placement: 'bottom',
            yOffset: 'center',
            title: 'Great! Now Let`s Add Some Friends!',
            showPrevButton: false,
            onNext: function () {
                $('#wishfish-contact ul.dropdown-menu').css('display', 'block');
            },
            onPrev: function () {
//                window.location = "https://wish-fish.com/app/profile";
            }
        },
        {
            target: 'create-contact',
            placement: 'right',
            yOffset: 'center',
            title: 'Create New Contact',
            multipage: true,
            showPrevButton: false,
            showNextButton: false,
            onNext: function () {
                //window.location = "https://wish-fish.com/app/contacts/addContact";
            },
            onPrev: function () {
                window.location = "https://wish-fish.com/app/dashboard";
                $('#wishfish-contact ul.dropdown-menu').css('display', 'block');
            },
            //yOffset: -10,
            xOffset: -20
        },
        {
            target: 'add-profile-pic',
            placement: 'left',
            title: 'Add Profile Picture',
            arrowOffset: 20,
            showPrevButton: false
        },
        {
            target: 'add-name',
            placement: 'left',
            title: 'Add First Name and Last Name',
            arrowOffset: 20,
            showPrevButton: false
        },
        {
            target: 'add-birthday',
            placement: 'left',
            title: 'Add Birthdate',
            arrowOffset: 20,
            showPrevButton: false
        },
        {
            target: 'add-phone',
            placement: 'left',
            title: 'Add Phone Number',
            arrowOffset: 20,
            showPrevButton: false
        },
        {
            target: 'save-contact',
            placement: 'left',
            title: "Awesome! Now Click 'Create New Contact!'",
            arrowOffset: "center",
            multipage: true,
            showPrevButton: false,
            showNextButton: false,
//            onNext: function () {
//                var form = $('#contactForm')[0]; // You need to use standart javascript object here
//                var formData = new FormData(form);
//                $.ajax({
//                    type: 'POST',
//                    processData: false,
//                    contentType: false,
//                    data: formData,
//                    url: "https://wish-fish.com/app/contacts/createContact?type=ajax",
//                    success: function (data, textStatus, jqXHR) {
//                        window.location = "https://wish-fish.com/app/calender?date=" + data;
//                    }
//                });
//            }
        },
        {
            target: 'birth_day',
            placement: 'left',
            delay: 0,
            zindex: 1,
            showNextButton: false,
            showPrevButton: false,
            title: 'This is your event for your friend click on it'
        },
        {
            target: 'birth_day',
            placement: 'left',
            delay: 200,
            zindex: 1,
            title: 'Awesome! You Just Scheduled Birthday Event!',
            content: 'Wish-Fish will message you(or him,if they selected that option).',
            showPrevButton: false,
            //yOffset: 120,
        },
        {
            target: 'birth_day',
            placement: 'left',
            title: 'That`s it! Its that easy!',
            content: 'Enjoy if you have any question or feedback for us we`re always happy to here from you,Just <a id="query_popup" href="#" onclick="return check()" data-toggle="modal" data-target="#query-modal">click Here</a>',
            zindex: 1,
            showPrevButton: false,
        }
    ],
    showPrevButton: true,
    scrollTopMargin: 100
};

hopscotch.startTour(tour);
//console.log(hopscotch.getState());



function check() {
    $('#supportForm .msg').text('');
    setTimeout(function () {
        $('.modal-backdrop').css('z-index', '999');
    }, 500);
}

$('#wishfish-profile a').click(function () {
    if (hopscotch.getState() == "welcome:4") {
//        console.log("CKICK :" + hopscotch.getState());
        hopscotch.nextStep();
    }
});
$('#profile_submit').click(function () {
    if (hopscotch.getState() == "welcome:10") {
//        console.log("PROFILE :" + hopscotch.getState());
        hopscotch.nextStep();
    }
});
$('#create-contact a').click(function () {
    if (hopscotch.getState() == "welcome:12:10") {
//        console.log("CREATE C :" + hopscotch.getState());
        hopscotch.nextStep();
    }
});

//$('#query_popup').click(function () {
//    
//});

/* ========== */
/* TOUR SETUP */
/* ========== */
/*
 addClickListener = function (el, fn) {
 if (el.addEventListener) {
 el.addEventListener('click', fn, false);
 }
 else {
 el.attachEvent('onclick', fn);
 }
 },
 init = function () {
 var startBtnId = 'startTourBtn',
 calloutId = 'startTourCallout',
 mgr = hopscotch.getCalloutManager(),
 state = hopscotch.getState();
 
 if (state && state.indexOf('hello-hopscotch:') === 0) {
 // Already started the tour at some point!
 hopscotch.startTour(tour);
 }
 else {
 // Looking at the page for the first(?) time.
 setTimeout(function () {
 mgr.createCallout({
 id: calloutId,
 target: startBtnId,
 placement: 'right',
 title: 'Take an example tour',
 content: 'Start by taking an example tour to see Hopscotch in action!',
 yOffset: -25,
 arrowOffset: 20,
 width: 240
 });
 }, 100);
 }
 
 addClickListener(document.getElementById(startBtnId), function () {
 if (!hopscotch.isActive) {
 mgr.removeAllCallouts();
 hopscotch.startTour(tour);
 }
 });
 };
 
 init();
 */

