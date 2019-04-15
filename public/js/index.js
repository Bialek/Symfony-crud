document.querySelectorAll('.delete-article').forEach(reservation => {
    reservation.addEventListener('click', (e) => {
        e.preventDefault();
        if(confirm('Are you sure?')) {
            const id = e.target.getAttribute('data-id');
            fetch(`/reservation/delete/${id}`, {
                method: 'DELETE'
            }).then(res => window.location.reload()
            );
        }
    })
})