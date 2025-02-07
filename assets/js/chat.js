document.addEventListener("DOMContentLoaded", function () {
    const chatMessages = document.getElementById("chatMessages");
    chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll to bottom on load
});

function sendMessage(senderId, receiverId, chatId) {
    const messageInput = document.getElementById("messageInput");
    const messageText = messageInput.value.trim();

    if (messageText === "") return;

    fetch("../ajax/send_message.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `sender_id=${senderId}&receiver_id=${receiverId}&chat_id=${chatId}&message=${encodeURIComponent(messageText)}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const chatMessages = document.getElementById("chatMessages");

            // Create a new message div
            const messageDiv = document.createElement("div");
            messageDiv.classList.add("message", "sent");
            messageDiv.innerHTML = `<p>${messageText}</p><span class="time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>`;

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            messageInput.value = "";
        } else {
            console.error("Error sending message:", data.error);
        }
    })
    .catch(error => console.error("Request failed", error));
}
