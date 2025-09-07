import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Simple greeting function
function showGreeting() {
    alert('مرحبًا بك في MiniSocial! استمتع بتجربة التواصل الاجتماعي المستقبلية.');
}

// Execute the function on page load
document.addEventListener('DOMContentLoaded', function() {
    showGreeting();
});
