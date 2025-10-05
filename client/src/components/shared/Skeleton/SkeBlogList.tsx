
function SkeBlogList() {
  return (
    <div>
    <div className="h-6 w-1/3 bg-gray-300 rounded animate-pulse mb-4"></div>
    <div className="grid grid-cols-4 gap-5 mt-5">
      {[...Array(4)].map((_, idx) => (
        <div key={idx} className="flex flex-col gap-2 animate-pulse">
          <div className="relative h-[198px] bg-gray-300 rounded-xl" />
          <div className="h-4 bg-gray-300 rounded w-3/4" />
          <div className="flex gap-4 items-center text-[14px] text-gray-500">
            <div className="h-3 w-16 bg-gray-300 rounded" />
            <div className="w-[6px] h-[6px] rounded-full bg-gray-300" />
            <div className="h-3 w-20 bg-gray-300 rounded" />
          </div>
        </div>
      ))}
    </div>
    <div className="flex justify-center mt-8">
      <div className="h-10 w-32 bg-gray-300 rounded animate-pulse" />
    </div>
  </div>
  )
}

export default SkeBlogList