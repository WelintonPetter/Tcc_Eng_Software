
var btnSignin = document.querySelector("#signin");
var btnSignup = document.querySelector("#signup");

var body = document.querySelector("body");


btnSignin.addEventListener("click", function () {
   body.className = "sign-in-js"; 
});
btnSignin.addEventListener("click", function () {
    body.className = "sign-in-js";
    updateLanguage(languageSelect.value); // Adicione essa linha
});
btnSignup.addEventListener("click", function () {
    body.className = "sign-up-js";
})
document.addEventListener('DOMContentLoaded', () => {
    const languageSelect = document.getElementById('language-select');
    const textElements = {
        'pt': {
            'welcomeBack': 'Bem-vindo de volta!',
            'stayConnected': 'Para se manter conectado',
            'loginWithPersonalInfo': 'Faça login com suas informações pessoais',
            'signIn': 'Entrar',
            'createAccount': 'Criar Conta',
            'useEmailToRegister': 'ou use seu e-mail para cadastro:',
            'namePlaceholder': 'Nome',
            'emailPlaceholder': 'Email',
            'passwordPlaceholder': 'Senha',
            'signUp': 'Cadastrar',
            'letsStart': 'Vamos Começar?',
            'insertData': 'Insira seus dados e inicie sua jornada de eficiência',
            'inMaintenance': 'na gestão de manutenção conosco.',
            'loginToPlatform': 'Faça login na plataforma',
            'useEmailToLogin': 'ou use sua conta de e-mail:',
            'forgotPassword': 'Esqueceu sua senha?'
        },
        'en': {
            'welcomeBack': 'Welcome back!',
            'stayConnected': 'To stay connected',
            'loginWithPersonalInfo': 'Login with your personal info',
            'signIn': 'Sign In',
            'createAccount': 'Create Account',
            'useEmailToRegister': 'or use your email for registration:',
            'namePlaceholder': 'Name',
            'emailPlaceholder': 'Email',
            'passwordPlaceholder': 'Password',
            'signUp': 'Sign Up',
            'letsStart': 'Let\'s Start?',
            'insertData': 'Enter your details and start your journey of efficiency',
            'inMaintenance': 'in maintenance management with us.',
            'loginToPlatform': 'Login to the platform',
            'useEmailToLogin': 'or use your email account:',
            'forgotPassword': 'Forgot your password?'
        },
        'es': {
            'welcomeBack': '¡Bienvenido de nuevo!',
            'stayConnected': 'Para mantenerse conectado',
            'loginWithPersonalInfo': 'Inicia sesión con tu información personal',
            'signIn': 'Iniciar sesión',
            'createAccount': 'Crear Cuenta',
            'useEmailToRegister': 'o usa tu correo electrónico para registrarte:',
            'namePlaceholder': 'Nombre',
            'emailPlaceholder': 'Correo electrónico',
            'passwordPlaceholder': 'Contraseña',
            'signUp': 'Registrarse',
            'letsStart': '¿Empezamos?',
            'insertData': 'Ingrese sus datos y comience su viaje de eficiencia',
            'inMaintenance': 'en la gestión de mantenimiento con nosotros.',
            'loginToPlatform': 'Inicia sesión en la plataforma',
            'useEmailToLogin': 'o usa tu cuenta de correo:',
            'forgotPassword': '¿Olvidaste tu contraseña?'
        }
    };

    function updateLanguage(language) {
        document.querySelector('.title-primary').textContent = textElements[language]['welcomeBack'];
        document.querySelectorAll('.description-primary')[0].textContent = textElements[language]['stayConnected'];
        document.querySelectorAll('.description-primary')[1].textContent = textElements[language]['loginWithPersonalInfo'];
        document.getElementById('signin').textContent = textElements[language]['signIn'];
        document.querySelector('.title-second').textContent = textElements[language]['createAccount'];
        document.querySelector('.description-second').textContent = textElements[language]['useEmailToRegister'];
        document.querySelector('input[type="text"]').placeholder = textElements[language]['namePlaceholder'];
        document.querySelector('input[type="email"]').placeholder = textElements[language]['emailPlaceholder'];
        document.querySelector('input[type="password"]').placeholder = textElements[language]['passwordPlaceholder'];
        document.querySelector('.btn-second').textContent = textElements[language]['signUp'];
        document.querySelector('.title-primary').textContent = textElements[language]['letsStart'];
        document.querySelectorAll('.description-primary')[2].textContent = textElements[language]['insertData'];
        document.querySelectorAll('.description-primary')[3].textContent = textElements[language]['inMaintenance'];
        document.getElementById('signup').textContent = textElements[language]['signUp'];
        document.querySelectorAll('.title-second')[1].textContent = textElements[language]['loginToPlatform'];
        document.querySelectorAll('.description-second')[1].textContent = textElements[language]['useEmailToLogin'];
        document.querySelector('.password').textContent = textElements[language]['forgotPassword'];
    }

    languageSelect.addEventListener('change', (event) => {
        updateLanguage(event.target.value);
    });

    // Define o idioma padrão ao carregar a página
    updateLanguage('pt');
});
