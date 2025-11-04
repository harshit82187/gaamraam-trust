<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $(".user_name").on("blur", function() {
                const inputValue = $(this).val();
                const errorMessage = $("#nameError"); 
                errorMessage.text('');
                if (inputValue.match(/^[a-zA-Z\s'-]{2,30}$/)) {
                } else {
                    errorMessage.text("Please Enter Valid Name.");
                }
            });

            $(".email_input").on("blur", function() {
                const inputValue = $(this).val();
                const errorMessage = $("#emailError"); 
            
                errorMessage.text('');
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (emailPattern.test(inputValue)) {
                } else {
                    errorMessage.text("Please enter a valid email address.");
                }
            });

            $('.mobile_number').on('blur', function() {
            const mobile = $(this).val();
            const errorMessage = $("#errorMobile"); 
            errorMessage.text('');
            const mobilePattern = /^[0-9]{10}$/;

            if (mobilePattern.test(mobile)) {
                errorMessage.hide();
            } else {
                errorMessage.text("Please enter a valid mobile number."); 
                errorMessage.show(); 
            }
        });

         $(".kevalalpha").on("blur", function() {
            const inputValue = $(this).val();
            const errorMessage = $("#nameError");
            errorMessage.text('');
            const regex = /^[a-zA-Z\s'-]{2,30}$/;

            if (regex.test(inputValue)) {
            } else {
                errorMessage.text("Please enter a valid input");
            }
        });
    });
</script>