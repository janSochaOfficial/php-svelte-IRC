export async function pollMessage() {
  try {
    const response = await fetch("getMess.php");
    let data = await response.json();
    data = data.map((el => {
      const date = new Date(Date.parse(el.AddDate));
      el.SentDate = `${date.getHours()}:${date.getMinutes()}`
      return el;
    }));
    console.log(`data`, data);
    return data;
  } catch (error) {
    console.error("Error:", error);
    return [];
  }
}
