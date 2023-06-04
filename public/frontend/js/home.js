$(document).ready(function () {
    //Nice Select
    $("select").niceSelect();

    //Tooltip
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // service-slider starts
    $(".service-slider").click({
        dots: true,
        infinite: false,
        speed: 500,
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
    // service-slider ends
}); // Document.ready ends

// To Top Button Starts
const toTop = document.querySelector(".back-to-top");
if (toTop !== null) {
    window.addEventListener("scroll", () => {
        if (window.pageYOffset > 100) {
            toTop.classList.add("active");
        } else {
            toTop.classList.remove("active");
        }
    });
}
// To Top Button Ends

// Multistep Regestration form starts
const multiStepForm = document.querySelector("[data-multi-step]");
if (multiStepForm !== null) {
    const formSteps = [...multiStepForm.querySelectorAll("[data-step]")];
    let stepsListAfter = document.querySelectorAll(".registration-list li");

    let currentStep = formSteps.findIndex((step) => {
        return step.classList.contains("active");
    });

    if (currentStep < 0) {
        currentStep = 0;
        showCurrentStep();
    }

    multiStepForm.addEventListener("click", (e) => {
        let incrementor;
        if (e.target.matches("[data-next]")) {
            incrementor = 1;
        } else if (e.target.matches("[data-previous]")) {
            incrementor = -1;
        }

        if (incrementor == null) return;

        const inputs = [...formSteps[currentStep].querySelectorAll("input")];
        const allValid = inputs.every((input) => input.reportValidity());
        if (allValid || e.target.matches("[data-previous]")) {
            currentStep += incrementor;
            showCurrentStep();
        }
    });

    function showCurrentStep() {
        formSteps.forEach((step, index) => {
            step.classList.toggle("active", index === currentStep);
        });

        stepsListAfter.forEach((step, index) => {
            step.classList.toggle("active", index === currentStep);
        });
    }
}

// Multistep Regestration form ends
