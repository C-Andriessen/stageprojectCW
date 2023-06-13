function completeTask(task) {
    const tr = document.getElementById(`task${task.id}`);
    const token = document.querySelector('meta[name="csrf-token"]').content;

    if (tr.className == "strikeout") {
        fetch(`/user/tasks/${task.id}/unapprove/js`, {
            method: "PUT",
            mode: "same-origin",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
                "X-CSRF-TOKEN": token,
            },
            body: JSON.stringify(task),
        }).then(() => {
            tr.className = "";
            trStrike = false;
        });
    } else {
        fetch(`/user/tasks/${task.id}/approve`, {
            method: "PUT",
            mode: "same-origin",
            headers: {
                "Content-Type": "application/json; charset=utf-8",
                "X-CSRF-TOKEN": token,
            },
            body: JSON.stringify(task),
        }).then(() => {
            tr.className = "strikeout";
            trStrike = true;
        });
    }
}
