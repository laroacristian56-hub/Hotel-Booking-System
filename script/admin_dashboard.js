// --- INITIALIZE ---

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
        "reports-page"
    ];
    
    const buttons = [
        "dashboard-btn", 
        "rooms-btn", 
        "booking-btn", 
        "payment-btn", 
        "reports-btn"
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

function openReportsPage() {
    closeAllPages();
    mainTitle.innerText = "Reports";

    document.getElementById("reports-btn").classList.add("active");

    const pg = document.getElementById("reports-page");
    pg.style.display = "block";
    setTimeout(() => {
        pg.style.opacity = "1";
    }, 200);
}