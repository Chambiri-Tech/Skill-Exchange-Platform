
/* CONFIRM DELETE */
function confirmDelete() {
    return confirm("Are you sure you want to delete this skill?");
}

/* PASSWORD SHOW  HIDE */
function togglePassword(id) {
    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}

/* LIVE SEARCH SKILLS */
function searchSkills() {
    let input = document.getElementById("searchInput").value.toLowerCase();
    let skills = document.querySelectorAll(".skill-card");

    skills.forEach(skill => {
        let text = skill.textContent.toLowerCase();

        if (text.includes(input)) {
            skill.style.display = "block";
        } else {
            skill.style.display = "none";
        }
    });
}

/* FORM VALIDATION (ADD SKILL) */
function validateSkillForm() {
    let skill = document.getElementById("skill").value;

    if (skill.trim() === "") {
        alert("Skill name cannot be empty!");
        return false;
    }

    return true;
}

/* DARK MODE TOGGLE */
function toggleDarkMode() {
    document.body.classList.toggle("dark-mode");

    // Save preference
    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
}

/* LOAD SAVED THEME ON START */
window.onload = function () {
    if (localStorage.getItem("theme") === "dark") {
        document.body.classList.add("dark-mode");
    }
};