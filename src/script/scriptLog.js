const container = document.querySelector(".container");
const btnSignIn = document.getElementById("btn-sign-in");
const btnSignUp = document.getElementById("btn-sign-up");

btnSignIn.addEventListener("click", ()=>{
    container.classList.remove("toggle");
});
btnSignUp.addEventListener("click", ()=>{
    container.classList.add("toggle");
});

// Al cargar
if (localStorage.getItem("modo-oscuro") === "true") {
    document.body.classList.add("dark-mode");
  }
  
  // Al hacer clic
  toggleBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");
    localStorage.setItem("modo-oscuro", document.body.classList.contains("dark-mode"));
  });
  