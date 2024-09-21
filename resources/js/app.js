import './bootstrap';
import User from '../../app/Modules/UserModule/views/js/_user';

const user = new User();


document.addEventListener("DOMContentLoaded", function (event) {
    user.initialize();
});
