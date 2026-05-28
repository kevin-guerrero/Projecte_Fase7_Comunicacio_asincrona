// Helpers
function mostrarBloc(id) {
    ['bloc-login', 'bloc-registre', 'bloc-usuari'].forEach(b => {
        document.getElementById(b).style.display = (b === id) ? 'block' : 'none';
    });
}

// Comprovar sessió
async function comprovarSessio() {
    try {
        const res = await fetch('../API/auth.php');
        const data = await res.json();

        if (data.autenticat) {
            document.getElementById('nom-usuari').textContent = data.usuari.nom;
            document.getElementById('rol-usuari').textContent = data.usuari.rol;
            mostrarBloc('bloc-usuari');
        } else {
            mostrarBloc('bloc-login');
        }

    } catch {
        mostrarBloc('bloc-login');
    }
}

comprovarSessio();

// Alternar login i registre
document.getElementById('link-registre').addEventListener('click', e => {
    e.preventDefault();
    mostrarBloc('bloc-registre');
});

document.getElementById('link-login').addEventListener('click', e => {
    e.preventDefault();
    mostrarBloc('bloc-login');
});

// Login
document.getElementById('form-login').addEventListener('submit', async e => {
    e.preventDefault();

    const nom = document.getElementById('login-nom').value.trim();
    const contrasenya = document.getElementById('login-pass').value;
    const errorEl = document.getElementById('login-error');

    errorEl.style.display = 'none';

    if (!nom || !contrasenya) {
        errorEl.textContent = 'Omple tots els camps.';
        errorEl.style.display = 'block';
        return;
    }

    try {
        const res = await fetch('../API/auth.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nom, contrasenya })
        });

        const data = await res.json();

        if (res.ok) {
            document.getElementById('nom-usuari').textContent = data.usuari.nom;
            document.getElementById('rol-usuari').textContent = data.usuari.rol;
            mostrarBloc('bloc-usuari');
        } else {
            errorEl.textContent = data.error || 'Error al iniciar sessió.';
            errorEl.style.display = 'block';
        }

    } catch {
        errorEl.textContent = 'Error de connexió amb el servidor.';
        errorEl.style.display = 'block';
    }
});

// Registre
document.getElementById('form-registre').addEventListener('submit', async e => {
    e.preventDefault();

    const nom = document.getElementById('reg-nom').value.trim();
    const email = document.getElementById('reg-email').value.trim();
    const contrasenya = document.getElementById('reg-pass').value;
    const ubicacio = document.getElementById('reg-ubicacio').value.trim();
    const telefon = document.getElementById('reg-telefon').value.trim();

    const errorEl = document.getElementById('reg-error');
    const successEl = document.getElementById('reg-success');

    errorEl.style.display = 'none';
    successEl.style.display = 'none';

    if (!nom || !email || !contrasenya) {
        errorEl.textContent = 'Nom, email i contrasenya són obligatoris.';
        errorEl.style.display = 'block';
        return;
    }

    try {
        const res = await fetch('../API/register.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nom, email, contrasenya, ubicacio, telefon })
        });

        const data = await res.json();

        if (res.ok) {
            successEl.textContent = 'Compte creat! Ara pots iniciar sessió.';
            successEl.style.display = 'block';
            setTimeout(() => mostrarBloc('bloc-login'), 1800);
        } else {
            errorEl.textContent = data.error || 'Error en el registre.';
            errorEl.style.display = 'block';
        }

    } catch {
        errorEl.textContent = 'Error de connexió amb el servidor.';
        errorEl.style.display = 'block';
    }
});

// Logout
document.getElementById('btn-logout').addEventListener('click', async () => {
    await fetch('../API/logout.php', { method: 'POST' });
    mostrarBloc('bloc-login');
});