interface ClassNameProp {
	className?: string;
	containerClassName?: string;
}

type Value = {
	label: string;
	value: string;
};

type ChildrenProp = {
	children?: React.ReactNode;
};

type ComponentProp = ChildrenProp & ClassNameProp;
