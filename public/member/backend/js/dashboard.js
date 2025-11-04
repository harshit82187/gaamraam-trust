function logout() {
    Swal.fire({
        title: 'Are you sure?',
        text: '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText:'Logout! ',
        customClass: {
            popup: 'swal2-large',
            content: 'swal2-large'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = logoutUrl;  
            console.log("Harshit");
        }
    });
}