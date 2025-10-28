class TextAnimator {
    constructor(selector, delay) {
        this.welcomeTextElement = document.querySelector(selector);
        this.text = this.welcomeTextElement.innerHTML;
        this.delay = delay;
        this.index = 0;
    }

    showNextLetter() {
        this.welcomeTextElement.style.visibility = "visible";
        this.welcomeTextElement.innerHTML = this.text.substring(0, this.index);

        if (this.index === this.text.length) {
            const dot = document.getElementById("dot");
            dot.style.visibility = "visible";
        }
    }

    typeText() {
        if (this.index <= this.text.length) {
            setTimeout(() => {
                this.showNextLetter();
                this.index++;
                this.typeText();
            }, this.delay);
        } else {
            setInterval(() => {
                const dot = document.getElementById("dot");
                dot.style.visibility = dot.style.visibility === "visible" ? "hidden" : "visible";
            }, 500);
        }
    }
}

const greetingAnimator = new TextAnimator('.GreetingText', 100);
greetingAnimator.typeText();