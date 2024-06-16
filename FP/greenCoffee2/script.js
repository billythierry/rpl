document.addEventListener("DOMContentLoaded", function() {
    const leftArrow = document.querySelector('.left-arrow');
    const rightArrow = document.querySelector('.right-arrow');
    const slider = document.querySelector('.slider');

    if (leftArrow && rightArrow && slider) {
        /* Scroll to right */
        function scrollRight() {
            if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
                slider.scrollTo({
                    left: 0,
                    behavior: "smooth"
                });
            } else {
                slider.scrollBy({
                    left: window.innerWidth,
                    behavior: "smooth"
                });
            }
        }

        /* Scroll to left */
        function scrollLeft() {
            slider.scrollBy({
                left: -window.innerWidth,
                behavior: "smooth"
            });
        }

        /* Reset timer to scroll right */
        function resetTimer() {
            clearInterval(timerId);
            timerId = setInterval(scrollRight, 7000);
        }

        /* Event listeners for left and right arrows */
        leftArrow.addEventListener('click', function() {
            scrollLeft();
            resetTimer();
        });

        rightArrow.addEventListener('click', function() {
            scrollRight();
            resetTimer();
        });

        /* Testimonial slider */
        let slides = document.querySelectorAll('.testimonial-item');
        let index = 0;

        function nextSlide() {
            slides[index].classList.remove('active');
            index = (index + 1) % slides.length;
            slides[index].classList.add('active');
        }

        function prevSlide() {
            slides[index].classList.remove('active');
            index = (index - 1 + slides.length) % slides.length;
            slides[index].classList.add('active');
        }
    } else {
        console.error('One or more elements not found.');
    }
});