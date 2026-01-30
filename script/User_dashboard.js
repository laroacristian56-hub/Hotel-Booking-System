document.addEventListener("DOMContentLoaded", () => {
    openDashboardPage(); 
});

// FOR CLOCK
function updateClock() {
        const clockElement = document.getElementById('realtime-clock');
        const now = new Date();
        
        // "Fri, Jan 16, 2026 | 12:00:00 PM"
        const options = { 
            weekday: 'short', 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        };
        
    
        const dateString = now.toLocaleDateString('en-US', options).replace(',', ''); 
        
        clockElement.innerText = dateString.replace(/(\d{4})/, '$1 |'); 
    }

    updateClock();
    setInterval(updateClock, 1000);

    function openProfile() {
        const profilebg = document.getElementById("profile-modal-bg");

        profilebg.style.display = "flex";
        setTimeout(() => {
            profilebg.style.opacity = "1";
        },200);
    }

    function closeProfile() {
        const profilebg = document.getElementById("profile-modal-bg");

        profilebg.style.opacity = "0";
        setTimeout(() => {
            profilebg.style.display = "none";
        },250);
    }

// FOR OPENING PAGES

const mainTitle = document.getElementById("mainTitleText");

function closeAllPages() {
    
    const pages = [
        "dashboard-page", 
        "rooms-page", 
        "booking-page", 
        "payment-page", 
        "booking-status-page"
    ];
    
    const buttons = [
        "dashboard-btn", 
        "rooms-btn", 
        "booking-btn", 
        "payment-btn", 
        "booking-status-btn"
    ];

    pages.forEach(id => {
        const page = document.getElementById(id);
        if (page) {
            page.style.opacity = "0";
            setTimeout(() => {
                
                if (page.style.opacity === "0") {
                    page.style.display = "none";
                }
            }, 250);
        }
    });

    buttons.forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.classList.remove("active");
    });
}


function openDashboardPage() {
    closeAllPages();
    mainTitle.innerText = "Dashboard";

    document.getElementById("dashboard-btn").classList.add("active");

    const pg = document.getElementById("dashboard-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}

function openRoomPage() {
    closeAllPages();
    mainTitle.innerText = "Rooms";

    document.getElementById("rooms-btn").classList.add("active");

    const pg = document.getElementById("rooms-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}

function openBookingPage() {
    closeAllPages();
    mainTitle.innerText = "Booking";

    document.getElementById("booking-btn").classList.add("active");

    const pg = document.getElementById("booking-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}

function openPaymentPage() {
    closeAllPages();
    mainTitle.innerText = "Payment";

    document.getElementById("payment-btn").classList.add("active");

    const pg = document.getElementById("payment-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}

function openBookingStatusPage() {
    closeAllPages();
    mainTitle.innerText = "Status";

    document.getElementById("booking-status-btn").classList.add("active");

    const pg = document.getElementById("booking-status-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}document.addEventListener("DOMContentLoaded", () => {
    openDashboardPage(); 
});

// FOR CLOCK
function updateClock() {
        const clockElement = document.getElementById('realtime-clock');
        const now = new Date();
        
        // "Fri, Jan 16, 2026 | 12:00:00 PM"
        const options = { 
            weekday: 'short', 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        };
        
    
        const dateString = now.toLocaleDateString('en-US', options).replace(',', ''); 
        
        clockElement.innerText = dateString.replace(/(\d{4})/, '$1 |'); 
    }

    updateClock();
    setInterval(updateClock, 1000);

    function openProfile() {
        const profilebg = document.getElementById("profile-modal-bg");

        profilebg.style.display = "flex";
        setTimeout(() => {
            profilebg.style.opacity = "1";
        },200);
    }

    function closeProfile() {
        const profilebg = document.getElementById("profile-modal-bg");

        profilebg.style.opacity = "0";
        setTimeout(() => {
            profilebg.style.display = "none";
        },250);
    }

// FOR OPENING PAGES

const MainTitle = document.getElementById("mainTitleText");

function closeAllPages() {
    
    const pages = [
        "dashboard-page", 
        "rooms-page", 
        "booking-page", 
        "payment-page", 
        "booking-status-page"
    ];
    
    const buttons = [
        "dashboard-btn", 
        "rooms-btn", 
        "booking-btn", 
        "payment-btn", 
        "booking-status-btn"
    ];

    pages.forEach(id => {
        const page = document.getElementById(id);
        if (page) {
            page.style.opacity = "0";
            setTimeout(() => {
                
                if (page.style.opacity === "0") {
                    page.style.display = "none";
                }
            }, 250);
        }
    });

    buttons.forEach(id => {
        const btn = document.getElementById(id);
        if (btn) btn.classList.remove("active");
    });
}


function openDashboardPage() {
    closeAllPages();
    MainTitle.innerText = "Dashboard";

    document.getElementById("dashboard-btn").classList.add("active");

    const pg = document.getElementById("dashboard-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}

function openRoomPage() {
    closeAllPages();
    MainTitle.innerText = "Rooms";

    document.getElementById("rooms-btn").classList.add("active");

    const pg = document.getElementById("rooms-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}

function openBookingPage() {
    closeAllPages();
MainTitle.innerText = "Booking";

    document.getElementById("booking-btn").classList.add("active");

    const pg = document.getElementById("booking-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}

function openPaymentPage() {
    closeAllPages();
MainTitle.innerText = "Payment";

    document.getElementById("payment-btn").classList.add("active");

    const pg = document.getElementById("payment-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}

function openBookingStatusPage() {
    closeAllPages();
    MainTitle.innerText = "Status";

    document.getElementById("booking-status-btn").classList.add("active");

    const pg = document.getElementById("booking-status-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}


//User Dashboard image slider//

let next = document.querySelector('.next')
let prev = document.querySelector('.prev')

next.addEventListener('click', function(){
    let items = document.querySelectorAll('.items')
    document.querySelector('.slide').appendChild(items[0])
})

prev.addEventListener('click', function(){
    let items = document.querySelectorAll('.items')
    document.querySelector('.slide').prepend(items[items.length - 1]) 
})

//For self move images//

let Next = document.querySelector('.next');
let Prev = document.querySelector('.prev');
let slider = document.querySelector('.ImageSlider');


function moveNext() {
    let items = document.querySelectorAll('.items');
    document.querySelector('.slide').appendChild(items[0]);
}


function movePrev() {
    let items = document.querySelectorAll('.items');
    document.querySelector('.slide').prepend(items[items.length - 1]);
}


Next.addEventListener('click', moveNext);
Prev.addEventListener('click', movePrev);


let autoPlay = setInterval(moveNext, 3000); 

slider.addEventListener('mouseenter', () => {
    clearInterval(autoPlay);
});


slider.addEventListener('mouseleave', () => {
    autoPlay = setInterval(moveNext, 3000);
});