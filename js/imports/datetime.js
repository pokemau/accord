export function isToday(someDate){
    const today = new Date();
    return checkDate(someDate, today);
}
export function isYesterday(someDate){
    const yesterday = new Date();
    yesterday.setDate(yesterday.getDate() - 1);
    checkDate(someDate, yesterday);
}
export function checkDate(someDate, compareDate){
    return someDate.getDate() == compareDate.getDate() &&
      someDate.getMonth() == compareDate.getMonth() &&
      someDate.getFullYear() == compareDate.getFullYear()
}
export function tConvert (time) {
    let timeParts = time.split(":");
    let hours = parseInt(timeParts[0]);
    let minutes = parseInt(timeParts[1]);

    let ampm = hours >= 12 ? "pm" : "am";
    hours = hours % 12;
    hours = hours==0 ? 12 : hours;

    minutes = minutes < 10 ? "0" + minutes : minutes;

    return hours + ":" + minutes + " " + ampm;
}