function updateDate() {
    const dateElement = document.getElementById('currentDate');
    const now = new Date();
    const formattedDate = now.toISOString().split('T')[0]; // Format YYYY-MM-DD
    dateElement.innerHTML = `<i class="fas fa-download fa-sm text-white-50"></i> ${formattedDate}`;
}
updateDate();