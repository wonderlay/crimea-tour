function fetchTours(page = 1) {
    const city = document.getElementById('city').value;
    window.location.href = `tours.php?city=${city}&page=${page}`;
}