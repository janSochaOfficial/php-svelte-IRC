export async function logIn(name) {
  const formData = new FormData();
  formData.append("name", name);

  try {
    const response = await fetch("logUser.php", {
      method: "POST",
      body: formData,
    });

    if (!response.ok) {
      throw new Error("Message failed to send");
    }
  } catch (error) {
    console.error(error);
  }
}
