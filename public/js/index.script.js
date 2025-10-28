class TextAnimator {
    constructor(text, delay) {
        this.text = text;
        this.delay = delay;
        this.index = 0;
        this.cursorInterval = null; // variable to hold cursor interval
    }

    showNextLetter() {
        const welcomeText = document.getElementById("welcome");
        welcomeText.style.visibility = "visible";
        welcomeText.textContent = this.text.substring(0, this.index) + (this.index < this.text.length ? '|' : '');

        if (this.index === this.text.length) {
            const dot = document.getElementById("dot");
            dot.style.visibility = "visible";
            this.stopBlinkingCursor(); // stop blinking cursor after text is complete
        }
    }

    typeText() {
        if (this.index <= this.text.length) {
            const randomDelay = this.delay + Math.random() * 100 - 50; // random delay for irregular typing speed
            setTimeout(() => {
                this.showNextLetter();
                this.index++;
                this.typeText();
            }, randomDelay);
        }
    }

    blinkCursor() {
        this.cursorInterval = setInterval(() => {
            const welcomeText = document.getElementById("welcome");
            if (welcomeText.textContent.endsWith('|')) {
                welcomeText.textContent = welcomeText.textContent.slice(0, -1); // Remove cursor
            } else {
                welcomeText.textContent += '|'; // add cursor
            }
        }, 5000); // cursor blink speed 
    }

    stopBlinkingCursor() {
        if (this.cursorInterval) {
            clearInterval(this.cursorInterval); // clear the interval to stop blinking
            const welcomeText = document.getElementById("welcome");
            welcomeText.textContent = welcomeText.textContent.slice(0, -1); // reomove cursor
        }
    }
}


const animator = new TextAnimator("FliegenderTeppich ", 100);
animator.typeText();
animator.blinkCursor();

document.addEventListener('DOMContentLoaded', function() {
    const middleSegment = document.querySelector('.middle-segment');
    const banner = document.querySelector('.banner'); // make the glowing effect stronger for this div, and make more shooting starts for this div aswell, which can be easily seen
    const numberOfStars = 100;
    const numberOfShootingStars = 5;

    // create star
    for (let i = 0; i < numberOfStars; i++) {
        let star = document.createElement('div');
        star.className = 'star';
        star.style.top = `${Math.random() * 100}%`;
        star.style.left = `${Math.random() * 100}%`;
        star.style.animationDuration = `${Math.random() * 3 + 1}s`; // between 1 and 4 seconds
        star.style.animationDelay = `${Math.random() * 3}s`; // delay up to 3 seconds
        star.style.animationIterationCount = 'infinite'; // infinite repeats
        middleSegment.appendChild(star);
        banner.appendChild(star);
    }

    // create shooting star
    for (let i = 0; i < numberOfShootingStars; i++) {
        let shootingStar = document.createElement('div');
        shootingStar.className = 'shooting-star';
        shootingStar.style.left = `${Math.random() * 100}%`;
        shootingStar.style.top = `${Math.random() * 100}%`;
        shootingStar.style.animationDuration = '2s';
        shootingStar.style.animationDelay = `${Math.random() * 5}s`; // delay up to 5s
        shootingStar.style.animationIterationCount = 'infinite'; // infinite repeats
        middleSegment.appendChild(shootingStar);
        banner.appendChild(shootingStar);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.book-section');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            } else {
                entry.target.classList.remove('active'); // optional: remove the class if the section leaves the viewport
            }
        });
    }, { threshold: 0.1 }); // adjust threshold as needed

    sections.forEach(section => {
        observer.observe(section);
    });

    // Get the current URL
    const currentUrl = window.location.href;

    // Check if the URL contains the error parameter
    if (currentUrl.includes('error=usernotfound')) {
        // Display an alert to the user
        alert('Fehler: Benutzerkonto nicht gefunden.');
    } else if (currentUrl.includes('error=email_invalid')) {
        alert("Fehler: Email Addresse ungültig.");
    } else if (currentUrl.includes('error=passwordsdontmatch')) {
        alert("Fehler: Die Passwörter stimmen nicht überein.")
    }


});