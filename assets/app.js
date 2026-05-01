const modalButtons = document.querySelectorAll("[data-open-modal]");

modalButtons.forEach((button) => {
    button.addEventListener("click", () => {
        const modal = document.getElementById(button.dataset.openModal);
        if (modal) {
            modal.showModal();
        }
    });
});

document.querySelectorAll(".modal").forEach((modal) => {
    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.close();
        }
    });
});

document.querySelectorAll("[data-table-search]").forEach((input) => {
    input.addEventListener("input", () => {
        const table = document.getElementById(input.dataset.tableSearch);
        const term = input.value.trim().toLowerCase();

        table.querySelectorAll("tbody tr").forEach((row) => {
            row.hidden = !row.textContent.toLowerCase().includes(term);
        });
    });
});

const periodFilter = document.getElementById("periodFilter");
const metrics = {
    month: ["$64.200.000", "$72.100.000", "32", "18"],
    quarter: ["$184.600.000", "$126.900.000", "91", "47"],
    year: ["$612.400.000", "$238.700.000", "284", "156"],
};

periodFilter?.addEventListener("change", () => {
    document.querySelectorAll(".metric strong").forEach((node, index) => {
        node.textContent = metrics[periodFilter.value][index];
    });
});

document.querySelectorAll("form").forEach((form) => {
    form.addEventListener("submit", () => {
        const button = form.querySelector(".primary-btn");
        if (!button) {
            return;
        }

        const original = button.textContent;
        button.textContent = "Guardado";
        setTimeout(() => {
            button.textContent = original;
        }, 1400);
    });
});
