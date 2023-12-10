export async function sendMessage(name, message) {

  const formData = new FormData();
  formData.append('name', name);
  formData.append('message', message);

  try {
    const response = await fetch('sendMess.php', {
      method: 'POST',
      body: formData
    });

    if(!response.ok) {
      throw new Error('Message failed to send');
    }

  } catch (error) {
    console.error(error); 
  }

}
