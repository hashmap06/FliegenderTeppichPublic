function toggleSlidingMenu() {
    const slidingMenu = document.getElementById('SlidingContent');
    slidingMenu.classList.toggle('open');
}

const hamburgerIcon = document.getElementById('ClickSpaceMenu');
hamburgerIcon.addEventListener('click', toggleSlidingMenu);

document.addEventListener('click', function(event) {
    const slidingMenu = document.querySelector('.sliding-menu');
    const hamburgerIcon = document.getElementById('ClickSpaceMenu');
    document.body.style.overflow = 'hidden';

    if (!slidingMenu.contains(event.target) && !hamburgerIcon.contains(event.target)) {
        if (slidingMenu.classList.contains('open')) {
            button.classList.toggle("active");
        }
        slidingMenu.classList.remove('open');
        document.body.style.overflow = '';
    }
});

window.onscroll = function() {
    var navbar = document.querySelector('.navbar');
    var sticky = navbar.offsetTop;
    var contentElements = document.getElementsByClassName('content');

    for (var i = 0; i < contentElements.length; i++) {
        var currentMarginTop = parseInt(contentElements[i].style.marginTop) || 0;

        if (window.scrollY >= sticky) {
            navbar.classList.add("sticky");
            contentElements[i].style.marginTop = '80px';
        } else {
            navbar.classList.remove("sticky");
            contentElements[i].style.marginTop = '0px';
        }
    }
};

const button = document.getElementById("hauptnavigation");
const raphael = document.getElementById("ClickSpaceMenu");

raphael.addEventListener("click", () => {
    button.classList.toggle("active");
});

class IconManager {
    constructor() {
        this.isOpen = false;
        this.loginImage = document.getElementById('loginImage');
        this.loginImageClass = document.querySelector('.LoginIcon');
        this.formDropDown = document.querySelector('.formDropDown');
        this.Anmelden_Abmelden_Hover = document.querySelector('.Anmelden_Abmelden_Hover');


        this.toggleIconLogout = this.toggleIconLogout.bind(this);
        this.closeOnOutsideClick = this.closeOnOutsideClick.bind(this);

        this.loginImage.addEventListener('click', this.toggleIconLogout);

        document.addEventListener('click', this.closeOnOutsideClick, true);
    }

    toggleIconLogout(event) {
        this.isOpen = !this.isOpen;
        if (this.isOpen && !this.loginImageClass.classList.contains('open')) {
            console.log("function called and says: " + this.isOpen);

            this.loginImage.src = "../img/png icons/Logout icon.png";
            this.loginImageClass.classList.add('open');
            this.formDropDown.style.display = "block";
        } else {
            console.log("function called and says: " + this.isOpen);
        }
    }

    closeOnOutsideClick(event) {
        if ((!this.formDropDown.contains(event.target) && this.isOpen)) {
            this.isOpen = !this.isOpen;
            this.loginImage.src = "../img/png icons/Login icon.png";
            this.loginImageClass.classList.remove('open');
            this.formDropDown.style.display = "none";
            if (this.Anmelden_Abmelden_Hover.contains(event.target)) {
                this.isOpen = !this.isOpen;
                console.log("event runs and says: " + this.isOpen);
            } else {
                console.log("event runs and says: " + this.isOpen);
            }
        }
    }
}

const iconManager = new IconManager();

function OpenLoginMenu() {
    iconManager.toggleIconLogout();
}