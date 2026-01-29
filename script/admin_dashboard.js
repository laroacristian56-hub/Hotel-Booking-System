// --- INITIALIZE ---

document.addEventListener("DOMContentLoaded", () => {
    openDashboardPage(); 
});

// --- DARK THEME TOGGLE ---
function toggleTheme() {
    document.body.classList.toggle('dark-theme');
    
    // Save preference to local storage
    if (document.body.classList.contains('dark-theme')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
}

// Check preference on load
if (localStorage.getItem('theme') === 'dark') {
    document.body.classList.add('dark-theme');
}

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



// --- MODAL JAVASCRIPT ---
    var modal = document.getElementById("addRoomModal");
    var btn = document.getElementById("openAddRoomBtn");
    var span = document.getElementsByClassName("close-modal")[0];

    // Open Modal
    btn.onclick = function() {
        modal.style.display = "block";
        setTimeout(() => {
            modal.style.opacity = "1";
        },250);
    }

    // Close Modal on X click
    span.onclick = function() {
        modal.style.opacity = "0";
        setTimeout(() => {
            modal.style.display = "none";
        },250);
        
    }

    // Close Modal on outside click
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.opacity = "0";
            setTimeout(() => {
                modal.style.display = "none";
            },250);
        }
    }

    // --- FORM SUBMISSION (AJAX) ---
    document.getElementById('addRoomForm').addEventListener('submit', function(e) {
        e.preventDefault(); 

        var formData = new FormData(this);

        fetch('add_room.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("Error")) {
                alert("Something went wrong: " + data);
            } else {
                // Success!
                var noRoomsMsg = document.getElementById('no-rooms-msg');
                if(noRoomsMsg) noRoomsMsg.remove();

                document.getElementById('roomContainer').innerHTML += data;
                
                // Reset form and CLOSE modal
                document.getElementById('addRoomForm').reset();
                modal.style.display = "none";
                
                alert("Room Added Successfully!");
            }
        })
        .catch(error => console.error('Error:', error));
    });




    // --- EDIT MODAL LOGIC ---
var editModal = document.getElementById("editRoomModal");

function openEditModal(id, name, price, capacity, desc) {
    // 1. Fill the form with the data passed from the card
    document.getElementById('edit_room_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_capacity').value = capacity;
    document.getElementById('edit_description').value = desc;

    // 2. Show the modal
    editModal.style.display = "block";
    setTimeout(() => {
        editModal.style.opacity = "1";
    },250);
}

function closeEditModal() {
    setTimeout(() => {
        editModal.style.opacity = "0";
    },250);
    editModal.style.display = "none";
}

// Close if clicked outside
window.onclick = function(event) {
    if (event.target == editModal) {
    this.setTimeout(() => {
            editModal.style.opacity = "0";
        },250);
        editModal.style.display = "none";
    }
    
    var addModal = document.getElementById("addRoomModal");
    if (event.target == addModal) {
    this.setTimeout(() => {
            addModal.style.opacity = "0";
        },250);
        addModal.style.display = "none";
    }
}

// --- HANDLE UPDATE SUBMISSION ---
document.getElementById('editRoomForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if(!confirm("Save changes to this room?")) return;

    var formData = new FormData(this);

    fetch('update_delete_room.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data.trim() === "updated") {
            alert("Room updated successfully!");
            location.reload(); // Refresh to show changes
        } else {
            alert("Error: " + data);
        }
    });
});

// --- HANDLE DELETE ACTION ---
function deleteRoom() {
    var id = document.getElementById('edit_room_id').value;
    
    if(confirm("Are you sure you want to DELETE this room? This cannot be undone.")) {
        var formData = new FormData();
        formData.append('room_id', id);
        formData.append('action', 'delete');

        fetch('update_delete_room.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "deleted") {
                alert("Room deleted.");
                location.reload(); // Refresh to remove the card
            } else {
                alert("Error deleting: " + data);
            }
        });
    }
}