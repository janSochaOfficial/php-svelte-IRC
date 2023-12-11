import appConfig from "../appconfig.json";
export async function sendCommand(name, message) {
  const formData = new FormData();
  formData.append("name", name);
  const command = message.split(" ")[0].substring(1);
  formData.append("command", command);
  const value = message.split(" ").splice(1).join(" ");
  formData.append("value", value);

  if (command == "quit") {
    window.location.reload();
  }
  try {
    const response = await fetch(appConfig.apiLink + "sendCommand.php", {
      method: "POST",
      body: formData,
    });

    if (response.ok) {
      return await response.json();
    } else if (response.status == 400) {
      return await response.json();
    } else {
      return {
        Message: "Something went wrong on the server",
      };
    }
  } catch (error) {
    console.error(error);
  }
}
