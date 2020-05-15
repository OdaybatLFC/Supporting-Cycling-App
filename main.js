document.getElementById("navButton").style.display = "block";
try {
    document.getElementById("logout").style.display = "none";
} catch(e) {
    console.log(e);
}

function moveSidebar() {
    let width = document.getElementById("sidebar").style.width;
    if (width === '11.5rem') {
        document.getElementById("sidebar").style.width = '0';
    }
    else {
        document.getElementById("sidebar").style.width = '11.5rem';
    }
}

// function openSidebar() {
//     document.getElementById("sidebar").style.width = '0';
// }

function showMenu() {
    document.getElementById("csLink").style.display = "block";
    document.getElementById("gdLink").style.display = "block";
    document.getElementById("tfLink").style.display = "block";
    document.getElementById("rpLink").style.display = "block";
    document.getElementById("bsLink").style.display = "block";
    document.getElementById("gsLink").style.display = "block";
    document.getElementById("pfLink").style.display = "block";
}