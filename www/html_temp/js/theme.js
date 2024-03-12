const srcImageLight = "images/logo_complet_clair_compresse.jpg";
const srcImageDark = "images/logo_complet_sombre_compresse.jpg";

let theme = localStorage.getItem("theme");
// console.log("Theme au démarrage:", theme);
if (theme == "light") {
    // console.log("Thème clair trouvé.");
    // changerTheme(true);
} else if (theme == "dark") {
    // console.log("Thème sombre trouvé.");
    // changerTheme(false);
} else {
    // console.log("Pas de theme enregistré, on enregistre le thème clair par défaut.");
    localStorage.setItem("theme", "light");
    theme = "light";
}

if (theme == "light") {
    changerTheme(true, false);
} else {
    changerTheme(false, false);
}


window.onload = () => {
    const btnTheme = document.getElementById("checkbox-theme");

    if (localStorage.getItem("theme") == "dark") {
        btnTheme.checked = true;
    }
    
    // console.log("btnTheme", btnTheme.checked);

    btnTheme.addEventListener("change", () => {
        // console.log("btnTheme cliqué, nouvel état=", btnTheme.checked);
        if (btnTheme.checked) {
            localStorage.setItem("theme", "dark");
            changerTheme(false, true);
        } else {
            localStorage.setItem("theme", "light");
            changerTheme(true, true);
        }
        // console.log("theme", localStorage.getItem("theme"));
    });

    changerTheme(!btnTheme.checked, true);
};

function changerTheme(light, logo) {
    // console.log("changerTheme, clair=", light)
    
    if (light) {
        document.documentElement.style.setProperty("--primary-color", "#333333");
        document.documentElement.style.setProperty("--secondary-color", "#cecece");
        document.documentElement.style.setProperty("--accent-color-1", "#2e4283");
        document.documentElement.style.setProperty("--accent-color-2", "#454acc");
        document.documentElement.style.setProperty("--alternate-color", "#ffffff");
        document.documentElement.style.setProperty("--background-color", "#ffffff");
        document.documentElement.style.setProperty("--background-color-2", "#eeeeee");
    } else {
        document.documentElement.style.setProperty("--primary-color", "#ffffff");
        document.documentElement.style.setProperty("--secondary-color", "#bbbbbb");
        document.documentElement.style.setProperty("--accent-color-1", "#2e4283");
        document.documentElement.style.setProperty("--accent-color-2", "#454acc");
        document.documentElement.style.setProperty("--alternate-color", "#ffffff");
        document.documentElement.style.setProperty("--background-color", "#0d0d0d");
        document.documentElement.style.setProperty("--background-color-2", "#aaaaaa");
    }

    if (logo) {
        changerLogo(light);
    }
}

function changerLogo(light) {
    const logoLight = document.getElementById("logo-light");
    const logoDark = document.getElementById("logo-dark");

    if (logoLight === null || logoDark == null) {
        return;
    }

    if (light) {
        logoLight.style.display = "block";
        logoDark.style.display = "none";
    } else {
        logoLight.style.display = "none";
        logoDark.style.display = "block";
    }
}