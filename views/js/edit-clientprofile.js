$(function(){

    $("#btn-change-password").click(function(){

        let requiredFields = [
            { id: "#oldpassword", label: "Old Password" },
            { id: "#newpassword", label: "New Password" },
            { id: "#retypepassword", label: "Re-type Password" }
        ];

        let emptyFields = [];

        requiredFields.forEach(function(field){

            let value = $(field.id).val();

            if(!value || value.trim() === ''){
                emptyFields.push(field.label);
            }

        });

        if(emptyFields.length > 0){

            Swal.fire({
                title: 'Password fields must not be empty',
                icon: 'warning',
                confirmButtonText: 'Ok',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });

        }else{

            let newpassword = $("#newpassword").val();
            let retypepassword = $("#retypepassword").val();

            if(newpassword != retypepassword){

                Swal.fire({
                    title: 'Passwords do not match!',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    customClass: {
                        confirmButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

            }else{

                Swal.fire({
                    title: 'Do you want to change your password?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false

                }).then(function(result){

                    if(result.value){
                        changePassword();
                    }

                });

            }

        }

    });

    function changePassword(){

        let clientid = $("#clientid").val();
        let oldpassword = $("#oldpassword").val();
        let newpassword = $("#newpassword").val();

        let changeData = new FormData();

        changeData.append("clientid", clientid);
        changeData.append("oldpassword", oldpassword);
        changeData.append("newpassword", newpassword);

        $.ajax({

            url: "ajax/changepassword.ajax.php",
            method: "POST",
            data: changeData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "text",

            success:function(answer){

                console.log(answer);

                // PASSWORD DOES NOT EXIST
                if(answer == "incorrect"){

                    Swal.fire({
                        title: 'Old password is incorrect!',
                        text: 'Please enter your correct current password.',
                        icon: 'error',
                        confirmButtonText: 'Ok',
                        customClass: {
                            confirmButton: 'btn btn-danger waves-effect waves-light'
                        },
                        buttonsStyling: false
                    });

                }

                // PASSWORD UPDATED
                else if(answer == "success"){

                    Swal.fire({
                        title: 'Password successfully changed!',
                        text: 'Your account password has been updated.',
                        icon: 'success',
                        confirmButtonText: 'Ok',
                        customClass: {
                            confirmButton: 'btn btn-success waves-effect waves-light'
                        },
                        buttonsStyling: false
                    }).then(function(result){

                        if(result.value){
                            window.location = 'edit-clientprofile';
                        }

                    });

                }

                // DATABASE ERROR
                else{

                    Swal.fire({
                        title: 'Something went wrong!',
                        text: 'Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'Ok',
                        customClass: {
                            confirmButton: 'btn btn-danger waves-effect waves-light'
                        },
                        buttonsStyling: false
                    });

                }

            }

        });

    }

});