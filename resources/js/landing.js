import AOS from 'aos';
import 'aos/dist/aos.css';

        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Animate timeline line when it enters viewport
        const timelineLine = document.getElementById('timeline-line');
        if (timelineLine) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Small delay so user sees it start from 0
                        setTimeout(() => {
                            timelineLine.style.width = '100%';
                        }, 300);
                        observer.disconnect();
                    }
                });
            }, {
                threshold: 0.3
            });
            observer.observe(timelineLine);
        }
   