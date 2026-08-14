   <!-- Back-to-top button Start -->
   <div class="paginacontainer">
       <div class="progress-wrap bounce">
           <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
               <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
           </svg>
       </div>
   </div>
   <!-- Back-to-top button End -->

   <!-- Link of JS files -->
   <script src="assets/js/jquery.min.js"></script>
   <script src="assets/js/bootstrap.bundle.min.js"></script>
   <script src="assets/js/form-validator.min.js"></script>
   <script src="assets/js/contact-form-script.js"></script>
   <script src="assets/js/aos.js"></script>
   <script src='https://unpkg.com/ionicons@5.0.0/dist/ionicons.js'></script>
   <script src="assets/js/owl.carousel.min.js"></script>
   <script src="assets/js/odometer.min.js"></script>
   <script src="assets/js/fancybox.js"></script>
   <script src="assets/js/jquery.appear.js"></script>
   <script src="assets/js/tweenmax.min.js"></script>
   <script src="assets/js/main.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
   <script src="assets/js/motion.js"></script>

   <script>
    $(document).ready(function() {
        $('#newsletter-form').submit(function(e) {
            e.preventDefault(); // Prevent form submission

            var email = $('#newsletter-email').val(); // Get the entered email address
            console.log(isValidEmail(email));
            // Validate the email address
            if (isValidEmail(email)) {
                // Perform AJAX request or any other necessary action to handle the subscription
                // You can replace the below code with your own logic

                // Simulating a successful subscription for demonstration purposes
                $('#newsletter-success').text('Thank you for subscribing to our newsletter!');
                $('#newsletter-error').text('');
                $('#newsletter-email').val(''); // Clear the input field after successful submission
            } else {
                // Display error message if email is invalid
                $('#newsletter-error').text('Please enter a valid email address.');
                $('#newsletter-success').text('');
            }
        });

        // Email validation function
        function isValidEmail(email) {
            // Regular expression for email validation
            var emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            return emailRegex.test(email);
        }
    });
   </script>

    <!-- Whatsapp tab function -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const whatsappButton = document.getElementById("whatsappButton");
            const whatsappPopup = document.getElementById("whatsappPopup");

            whatsappButton.addEventListener("click", function() {
                whatsappPopup.style.display = (whatsappPopup.style.display === "block") ? "none" : "block";
            });

            document.addEventListener("click", function(event) {
                if (!whatsappButton.contains(event.target) && !whatsappPopup.contains(event.target)) {
                    whatsappPopup.style.display = "none";
                }
            });
        });
    </script>