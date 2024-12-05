// Highlight active menu links
document.addEventListener("DOMContentLoaded", () => {
    const currentPath = window.location.pathname.split("/").pop();
    const menuLinks = document.querySelectorAll("ul li a");

    menuLinks.forEach(link => {
        if (link.getAttribute("href") === currentPath) {
            link.style.color = "#4CAF50";
            link.style.textDecoration = "underline";
        }
    });
});

// Confirmation dialog for deletion
const deleteButtons = document.querySelectorAll("form button[name='delete_category'], form button[name='delete_product'], form button[name='delete_user'], form button[name='delete_customer'], form button[name='delete_order']");

deleteButtons.forEach(button => {
    button.addEventListener("click", (event) => {
        const confirmed = confirm("Are you sure you want to delete this item?");
        if (!confirmed) {
            event.preventDefault();
        }
    });
});
