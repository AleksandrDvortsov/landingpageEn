/* Theme Name:  Kasy- Responsive Landing page template
  File Description: Main JS file of the template
*/



//  Window scroll sticky class add
function windowScroll() {
    const navbar = document.getElementById("navbar");
    if (
        document.body.scrollTop >= 50 ||
        document.documentElement.scrollTop >= 50
    ) {
        navbar.classList.add("nav-sticky");
    } else {
        navbar.classList.remove("nav-sticky");
    }
}

window.addEventListener('scroll', (ev) => {
    ev.preventDefault();
    windowScroll();
})

// Swiper slider

var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    loopFillGroupWithBlank: true,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
});



//
/********************* scroll top js ************************/
//

var mybutton = document.getElementById("back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {
    scrollFunction();
};

function scrollFunction() {
    if (
        document.body.scrollTop > 100 ||
        document.documentElement.scrollTop > 100
    ) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}


// 
// Typed Text animation (animation)
// 

try {
    var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };
    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];
        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }
        this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';
        var that = this;
        var delta = 200 - Math.random() * 100;
        if (this.isDeleting) { delta /= 2; }
        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }
        setTimeout(function() {
            that.tick();
        }, delta);
    };

    function typewrite() {
        if (toRotate === 'undefined') {
            changeText()
        } else
            var elements = document.getElementsByClassName('typewrite');
        for (var i = 0; i < elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid transparent}";
        document.body.appendChild(css);
    };
    window.onload(typewrite());
} catch (err) {}


// particles
if ($("#tsparticles2").length != 0) {
    tsParticles
        .load("tsparticles2", {
            fpsLimit: 60,
            fullScreen: { enable: false },
            particles: {
                number: {
                    value: 5
                },
                shape: {
                    type: "image",
                    options: {
                        image: [{
                                src: "./images/telephonebox.png",
                                width: 202,
                                height: 200
                            }, {
                                src: "./images/taxi.png",
                                width: 1153,
                                height: 1080
                            },
                            {
                                src: "./images/bigben.png",
                                width: 1153,
                                height: 1080
                            },
                            {
                                src: "./images/towerbridge.png",
                                width: 1153,
                                height: 1080
                            },
                            {
                                src: "./images/londoneye.png",
                                width: 1153,
                                height: 1080
                            },
                            {
                                src: "./images/guardroyal-1.png",
                                width: 1153,
                                height: 1080
                            },
                            {
                                src: "./images/guardroyal-2.png",
                                width: 1153,
                                height: 1080
                            },
                            {
                                src: "./images/guardroyal-3.png",
                                width: 1153,
                                height: 1080
                            }
                        ]
                    },
                },
                opacity: {
                    value: 0.5

                },

                size: {
                    value: 40,
                    random: {
                        enable: true,
                        minimumValue: 20
                    }
                },
                move: {
                    enable: true,
                    speed: 10,
                    direction: "top",
                    outModes: {
                        default: "out",
                        top: "destroy",
                        bottom: "none"
                    }
                }
            },
            interactivity: {
                detectsOn: "canvas",
                events: {
                    resize: true
                }
            },
            detectRetina: true,
            themes: [{
                name: "light",
                default: {
                    value: true,
                    mode: "light"
                },
                options: {
                    background: {
                        color: "#f7f8ef"
                    },
                    particles: {
                        color: {
                            value: ["#5bc0eb", "#fde74c", "#9bc53d", "#e55934", "#fa7921"]
                        }
                    }
                }
            }],
            emitters: {
                direction: "top",
                position: {
                    x: 50,
                    y: 150
                },
                rate: {
                    delay: 0.2,
                    quantity: 2
                },
                size: {
                    width: 100,
                    height: 0
                }
            }
        })
        .then((cnt) => {
            console.log(cnt);
        });
}

if ($("#tsparticles").length != 0) {
    tsParticles
        .load("tsparticles", {
            fpsLimit: 60,
            fullScreen: { enable: false },
            particles: {
                number: {
                    value: 5
                },
                shape: {
                    type: "circle"
                },
                opacity: {
                    value: 0.5
                },
                size: {
                    value: 40,
                    random: {
                        enable: true,
                        minimumValue: 20
                    }
                },
                move: {
                    enable: true,
                    speed: 10,
                    direction: "top",
                    outModes: {
                        default: "out",
                        top: "destroy",
                        bottom: "none"
                    }
                }
            },
            interactivity: {
                detectsOn: "canvas",
                events: {
                    resize: true
                }
            },
            detectRetina: true,
            themes: [{
                name: "light",
                default: {
                    value: true,
                    mode: "light"
                },
                options: {
                    background: {
                        color: "#f7f8ef"
                    },
                    particles: {
                        color: {
                            value: ["#5bc0eb", "#fde74c", "#9bc53d", "#e55934", "#fa7921"]
                        }
                    }
                }
            }],
            emitters: {
                direction: "top",
                position: {
                    x: 50,
                    y: 150
                },
                rate: {
                    delay: 0.2,
                    quantity: 2
                },
                size: {
                    width: 100,
                    height: 0
                }
            }
        })
        .then((cnt) => {
            console.log(cnt);
        });
}



// particlesJS("particles-js", {
//     "particles": {
//         "number": {
//             "value": 10,
//             "density": {
//                 "enable": false
//             }
//         },
//         "color": {
//             "value": "#1e304d"
//         },
//         "shape": {
//             "type": ["image"],
//             "stroke": {
//                 "width": 0,
//                 "color": "#000000"
//             },
//             "image": [{
//                 "src": "./images/telephonebox.png"
//             }, {
//                 "src": "./images/taxi.png"
//             }, {
//                 "src": "./images/bigben.png"
//             }]
//         },
//         "opacity": {
//             "value": 1,
//             "random": false,
//             "anim": {
//                 "enable": false,
//                 "speed": 10,
//                 "opacity_min": 0.1,
//                 "sync": false
//             }
//         },
//         "size": {
//             "value": 30,
//             "random": false,
//             "anim": {
//                 "enable": false,
//                 "speed": 40,
//                 "size_min": 0.1,
//                 "sync": false
//             }
//         },
//         "rotate": {
//             "value": {
//                 "min": 0,
//                 "max": 360
//             },
//             "direction": "random",
//             "move": true,
//             "animation": {
//                 "enable": true,
//                 "speed": 60
//             }
//         },
//         "line_linked": {
//             "enable": false,
//             "distance": 150,
//             "color": "#ffffff",
//             "opacity": 0.4,
//             "width": 1
//         },
//         "move": {
//             "enable": true,
//             "speed": 3,
//             "direction": "none",
//             "random": true,
//             "straight": false,
//             "out_mode": "out",
//             "bounce": true,
//             "attract": {
//                 "enable": true,
//                 "rotateX": 600,
//                 "rotateY": 1200
//             }
//         }
//     },
//     "interactivity": {
//         "detect_on": "canvas",
//         "events": {
//             "onhover": {
//                 "enable": true,
//                 "mode": "grab"
//             },
//             "onclick": {
//                 "enable": false,
//                 "mode": "push"
//             },
//             "resize": true
//         },
//         "modes": {
//             "grab": {
//                 "distance": 150,
//                 "line_linked": {
//                     "opacity": 1
//                 }
//             },
//             "bubble": {
//                 "distance": 400,
//                 "size": 40,
//                 "duration": 2,
//                 "opacity": 8,
//                 "speed": 3
//             },
//             "repulse": {
//                 "distance": 200,
//                 "duration": 0.4
//             },
//             "push": {
//                 "particles_nb": 4
//             },
//             "remove": {
//                 "particles_nb": 2
//             }
//         }
//     },
//     "retina_detect": true
// });

// home3 swiper slider 

var swiper = new Swiper(".mySwiper2", {
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
    },
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
});

// Animaten js



AOS.init();