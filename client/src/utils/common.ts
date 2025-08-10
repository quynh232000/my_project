
export function formatDate(date: string | number | Date): string {
    const d = new Date(date); // ép kiểu về Date
    const year = d.getFullYear();
    const month = `${d.getMonth() + 1}`.padStart(2, '0');
    const day = `${d.getDate()}`.padStart(2, '0');

    return `${year}-${month}-${day}`;
}
// export const FormMartDateAgo = (date: string) => {
//   let result = moment(date).fromNow();
//   result = result.replace("a few seconds ago", "vừa xong");
//   result = result.replace("an hour", "1 giờ");
//   result = result.replace("a day", "1 ngày");
//   result = result.replace("an month", "1 tháng");
//   result = result.replace("an year", "1 năm");
//   result = result.replace("ago", "trước");
//   result = result.replace("a minute", "1 phút");
//   result = result.replace("minutes", "phút");
//   result = result.replace("hours", "giờ");
//   result = result.replace("days", "ngày");
//   result = result.replace("months", "tháng");
//   result = result.replace("a month", "1 tháng");
//   result = result.replace("years", "năm");
//   return result;
// };
export const FormatPrice = (price: number) => {
    return new Intl.NumberFormat("vi-VN", {
        style: "currency",
        currency: "VND",
        minimumFractionDigits: 0,
    }).format(price);
};

export const FormatDate = (
    timestamp: string | Date,
    withTime: boolean = false,
) => {
    const date = new Date(timestamp);
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const year = date.getFullYear();
    if (withTime) {
        const vietnamOffset = 7 * 60;
        const vietnamTime = new Date(date.getTime() + vietnamOffset * 60 * 1000);
        return vietnamTime.toISOString().slice(0, 19).replace("T", " ");
    } else {
        return `${day}/${month}/${year}`;
    }
};
export const formatDuration = (seconds: number, is_text = true) => {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = seconds % 60;

    if (is_text) {
        if (hours == 0) {
            if (minutes == 0) {
                return `${remainingSeconds} giây`;
            }
            return `${minutes} phút:${remainingSeconds} giây`;
        }
        return `${hours} giờ:${minutes} phút:${remainingSeconds} giây`;
    } else {
        if (hours == 0) {
            if (minutes == 0) {
                return `${remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds
                    }`;
            }
            return `${minutes < 10 ? "0" + minutes : minutes} :${remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds
                } `;
        }
        return `${hours < 10 ? "0" + hours : hours}:${minutes < 10 ? "0" + minutes : minutes
            }:${remainingSeconds < 10 ? "0" + remainingSeconds : remainingSeconds} `;
    }
};
export const CompareDateNow = (
    data_start: Date | string,
    data_end: Date | string,
) => {
    const dateStart = new Date(data_start);
    const dateEnd = new Date(data_end);
    const now = new Date();

    let status;

    if (now < dateStart) {
        status = "soon";
    } else if (now >= dateStart && now <= dateEnd) {
        status = "running";
    } else {
        status = "outdated";
    }
    return status;
    // const mess:{[key:string]:{[key:string]:string}}={
    //   soon:{
    //     vi:'Sắp diễn ra'
    //   },
    //   running:{
    //     vi:'Đang diễn ra'
    //   },
    //   outdated:{
    //     vi:'Đã kết thúc'
    //   },
    // }
    // return mess[status][lang];
};
export const ConvertOldPrice = (
    price: string | number,
    percent_sale: string | number | null,
) => {
    if (percent_sale == 0 || percent_sale == null || percent_sale == "") {
        return;
    }
    const value = Math.round(Math.ceil((+price / (100 - +percent_sale)) * 100));
    if (value > 100000) {
        return FormatPrice(Math.round(value / 1000) * 1000);
    }
    return FormatPrice(value);
};
export const GetPriceSale = (
    price: string | number,
    percent_sale: string | number | null,
) => {
    if (percent_sale == 0 || percent_sale == null || percent_sale == "") {
        return;
    }
    const value = Math.round(Math.ceil((+price / (100 - +percent_sale)) * 100));
    if (value > 100000) {
        return FormatPrice(Math.round((value - +price) / 1000) * 1000);
    }
    return FormatPrice(value - +price);
};
// export const ParseParams = (data: IKeyValue) => {
//   return new URLSearchParams(
//     Object.entries(data).reduce(
//       (acc, [key, value]) => {
//         acc[key] = String(value);
//         return acc;
//       },
//       {} as { [key: string]: string },
//     ),
//   );
// };
export function getRandomInt(min: number, max: number) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}
export function getFeatureDate(number: number) {
    const date = new Date();
    date.setDate(date.getDate() + number);

    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0'); // luôn +1 vì getMonth() trả về 0-11
    const day = String(date.getDate()).padStart(2, '0');

    return `${year}-${month}-${day}`;
}
export function objectToParams(params: Record<string, any>): string {
    const searchParams = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {
        if (value === undefined || value === null) return;

        if (Array.isArray(value)) {
            value.forEach((v) => searchParams.append(key, String(v)));
        } else {
            searchParams.set(key, String(value));
        }
    });

    return searchParams.toString(); // ví dụ: "a=1&b=2&c=3"
}

export function startCountdown(
    seconds: number,
    onTick: (formattedTime: string) => void,
    onComplete?: () => void
) {
    let remaining = seconds;

    const formatTime = (sec: number) => {
        const m = Math.floor(sec / 60);
        const s = sec % 60;
        return `${String(m).padStart(2, "0")}:${String(s).padStart(2, "0")}`;
    };

    onTick(formatTime(remaining)); // Gọi lần đầu

    const timer = setInterval(() => {
        remaining -= 1;
        onTick(formatTime(remaining));

        if (remaining <= 0) {
            clearInterval(timer);
            if (onComplete) onComplete();
        }
    }, 1000);

    return () => clearInterval(timer);
}
export function formatVietnameseDate(dateString: string): string {
    const days = ["CN", "T2", "T3", "T4", "T5", "T6", "T7"];
    const date = new Date(dateString);

    const dayName = days[date.getDay()];
    const day = date.getDate();
    const month = date.getMonth() + 1; // Tháng bắt đầu từ 0
    const year = date.getFullYear();

    return `${dayName}, ${day} tháng ${month}, ${year}`;
}