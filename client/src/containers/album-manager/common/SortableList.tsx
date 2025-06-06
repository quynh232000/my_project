import {
	closestCenter,
	DndContext,
	DragEndEvent,
	DragOverlay,
	DragStartEvent,
	MouseSensor,
	TouchSensor,
	useSensor,
	useSensors,
} from '@dnd-kit/core';
import {
	arrayMove,
	rectSortingStrategy,
	SortableContext,
} from '@dnd-kit/sortable';
import React, { useState } from 'react';
import { cn } from '@/lib/utils';
import UploadImageZone from '@/containers/album-manager/common/UploadImageZone';
import SortableItem from '@/containers/album-manager/common/SortableItem';
import { ImageType } from '@/containers/album-manager/common/ImageGalleryList';
import { updateAlbum } from '@/services/album/updateAlbum';
import { useLoadingStore } from '@/store/loading/store';
import Item from '@/containers/album-manager/common/Item';
import { HotelRoomsResponse } from '@/services/album/getAlbumHotel';
import { useAlbumHotelStore } from '@/store/album/store';

interface SortableListProps extends React.HTMLAttributes<HTMLDivElement> {
	list: ImageType[];
	onCheck: (id: number | string, checked: boolean) => void;
	onMove: (list: ImageType[]) => void;
	onEdit: (id: number | string) => void;
	onRemove: (id: number | string) => void;
	roomId?: number;
}

export const SortableList = ({
	list,
	onCheck,
	onMove,
	onRemove,
	onEdit,
	roomId,
	...props
}: SortableListProps) => {
	const [activeId, setActiveId] = useState<string | null>(null);
	const setAlbumHotel = useAlbumHotelStore((state) => state.setAlbumHotel);
	const setLoading = useLoadingStore((state) => state.setLoading);
	const sensors = useSensors(
		useSensor(MouseSensor, {
			activationConstraint: { distance: 5 },
		}),
		useSensor(TouchSensor)
	);

	const draggingItem =
		activeId !== null && list.length > 0
			? list.find((item) => item.id === activeId)
			: undefined;

	const handleDragStart = (event: DragStartEvent) => {
		setActiveId(`${event.active.id}`);
	};

	const handleDragEnd = async (event: DragEndEvent) => {
		const { active, over } = event;
		const oldIndex = list.findIndex((item) => item.id === active.id);
		const newIndex = over ? list.findIndex((item) => item.id === over.id) : -1;
		if (oldIndex >= 0 && newIndex >= 0 && oldIndex !== newIndex) {
			setLoading(true);
			const newList = arrayMove(list, oldIndex, newIndex);
			const from = Math.min(oldIndex, newIndex);
			const to = Math.max(newIndex, oldIndex);
			const oldPriority = list.slice(from, to + 1).map((item) => item.priority);

			for (let i = from; i <= to; i++) {
				newList[i] = {
					...newList[i],
					priority: oldPriority[i - from],
				};
			}
			onMove(newList);

			const formData = new FormData();
			formData.append('id', String(roomId));
			formData.append('type', roomId ? 'room_type' : 'hotel');
			formData.append('list-all', 'true');
			newList.forEach((item) => {
				formData.append(
					`update[${item.image_id}][priority]`,
					String(item.priority)
				);
			});
			const res = await updateAlbum<HotelRoomsResponse>(formData).finally(() => setLoading(false));
			if (!res) {
				onMove(list);
			}else{
				setAlbumHotel(res.data);
			}
		}
		setActiveId(null);
	};

	const handleDragCancel = () => {
		setActiveId(null);
	};

	return (
		<div
			{...props}
			className={cn(
				`grid gap-4 rounded-lg border md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 ${activeId ? 'border-dashed border-secondary-500 bg-secondary-50' : 'border-transparent bg-white'}`,
				props.className
			)}>
			<DndContext
				sensors={sensors}
				collisionDetection={closestCenter}
				onDragStart={handleDragStart}
				onDragEnd={handleDragEnd}
				onDragCancel={handleDragCancel}>
				<SortableContext items={list} strategy={rectSortingStrategy}>
					{list
						?.sort((a, b) => a.priority - b.priority)
						.map((item) => (
							<SortableItem
								id={`${item.id}`}
								key={item.id}
								item={item}
								onCheck={onCheck}
								onEdit={onEdit}
								onRemove={onRemove}
							/>
						))}
				</SortableContext>
				<DragOverlay adjustScale style={{ transformOrigin: '0 0 ' }}>
					{draggingItem && <Item item={draggingItem} isDragging />}
				</DragOverlay>
			</DndContext>
			<UploadImageZone />
		</div>
	);
};
