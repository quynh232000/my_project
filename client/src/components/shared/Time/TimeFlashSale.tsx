
import { useEffect, useState } from "react";

function TimeFlashSale() {
  const [time, setTime] = useState({ hours: 0, minutes: 0, seconds: 0 });

  useEffect(() => {
    const updateTime = () => {
      const now = new Date();
      const endOfDay = new Date();
      endOfDay.setHours(23, 59, 59, 999);
      const diff = endOfDay.getTime() - now.getTime();

      if (diff > 0) {
        const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((diff / (1000 * 60)) % 60);
        const seconds = Math.floor((diff / 1000) % 60);
        setTime({ hours, minutes, seconds });
      }
    };

    updateTime(); // cập nhật lần đầu
    const interval = setInterval(updateTime, 1000);

    return () => clearInterval(interval);
  }, []);

  const format = (val: number) => (val < 10 ? `0${val}` : val);

  return (
    <div className="flex items-center rounded-xl  shadow-md">
      <div className="flex min-w-[280px] items-center justify-center gap-4 rounded-xl bg-yellow-500 px-6 py-3 text-white">
        <div className="text-lg font-semibold">Chỉ còn</div>
        <div className="flex items-center gap-1 text-xl font-bold">
          <span className="flash-box">{format(time.hours)}</span>
          <span>:</span>
          <span className="flash-box">{format(time.minutes)}</span>
          <span>:</span>
          <span className="flash-box">{format(time.seconds)}</span>
        </div>
      </div>
    </div>
  );
}

export default TimeFlashSale;
