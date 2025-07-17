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
import { rectSortingStrategy, SortableContext } from '@dnd-kit/sortable';
import React, { useState } from 'react';
import { ImageType } from '@/containers/setting-room/RoomImageSetting/common/RoomImageList';
import Item from '@/containers/album-manager/common/Item';
import SortableItem from '@/containers/album-manager/common/SortableItem';
import { reorderList } from '@/containers/album-manager/data';

interface SortableListProps {
	list: ImageType[];
	onEdit: (id: number | string) => void;
	onRemove: (id: number | string) => void;
	onMove: (list: ImageType[]) => void;
	showTag?: boolean;
}

export const SortableList = ({
	list,
	onEdit,
	onRemove,
	onMove,
	showTag = true,
}: SortableListProps) => {
	const [activeId, setActiveId] = useState<string | null>(null);

	const sensors = useSensors(
		useSensor(MouseSensor, {
			activationConstraint: { distance: 5 },
		}),
		useSensor(TouchSensor)
	);

	const draggingItem =
		activeId !== null && list.length > 0
			? list.find((item) => item?.id === activeId)
			: undefined;

	const handleDragStart = (event: DragStartEvent) => {
		setActiveId(`${event?.active?.id}`);
	};

	const handleDragEnd = (event: DragEndEvent) => {
		const { active, over } = event;
		const oldIndex = list.findIndex((item) => item?.id === active?.id);
		const newIndex = over
			? list.findIndex((item) => item?.id === over?.id)
			: -1;
		if (oldIndex >= 0 && newIndex >= 0 && oldIndex !== newIndex) {
			const newList = reorderList(list, oldIndex, newIndex);
			onMove(newList);
		}
		setActiveId(null);
	};

	const handleDragCancel = () => {
		setActiveId(null);
	};

	return (
		<div
			className={`grid gap-4 rounded-lg border px-4 py-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 ${activeId ? 'border-dashed border-secondary-500 bg-secondary-50' : 'border-transparent bg-white'}`}>
			<DndContext
				sensors={sensors}
				collisionDetection={closestCenter}
				onDragStart={handleDragStart}
				onDragEnd={handleDragEnd}
				onDragCancel={handleDragCancel}>
				<SortableContext
					items={list?.map((item) => ({
						...item,
						id: `${item?.id}`,
					}))}
					strategy={rectSortingStrategy}>
					{list
						?.sort((a, b) => a.priority - b.priority)
						.map((item) => (
							<SortableItem
								id={`${item?.id}`}
								key={item?.id}
								item={item}
								onEdit={onEdit}
								onRemove={onRemove}
								showTag={showTag}
							/>
						))}
				</SortableContext>
				<DragOverlay adjustScale style={{ transformOrigin: '0 0 ' }}>
					{draggingItem && (
						<Item item={draggingItem} isDragging showTag={false} />
					)}
				</DragOverlay>
			</DndContext>
		</div>
	);
};
