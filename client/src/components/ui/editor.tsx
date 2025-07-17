'use client';
import { useEffect, useRef, useState } from 'react';
import RcTiptapEditor, {
	BaseKit,
	Editor as EditorInstance,
} from 'reactjs-tiptap-editor';
import { Bold } from 'reactjs-tiptap-editor/bold';
import { BulletList } from 'reactjs-tiptap-editor/bulletlist';
import { Emoji } from 'reactjs-tiptap-editor/emoji';
import { Italic } from 'reactjs-tiptap-editor/italic';
import { Link } from 'reactjs-tiptap-editor/link';
import { locale } from 'reactjs-tiptap-editor/locale-bundle';
import { TextAlign } from 'reactjs-tiptap-editor/textalign';
import { TextUnderline } from 'reactjs-tiptap-editor/textunderline';
import 'reactjs-tiptap-editor/style.css';

interface EditorProps {
	content: string;
	onChange: (value: string) => void;
}

const Editor = ({ content, onChange }: EditorProps) => {
	const [isContentParsed, setIsContentParsed] = useState(false);
	const ref = useRef<{ editor: EditorInstance }>(null);
	const initialized = ref?.current?.editor?.isInitialized;
	const extensions = [
		BaseKit.configure({
			placeholder: {
				showOnlyCurrent: true,
			},
			characterCount: {
				limit: 300,
			},
		}),
		Bold,
		Italic,
		TextUnderline,
		Emoji,
		Link,
		BulletList,
		TextAlign.configure({ types: ['paragraph'] }),
	];

	useEffect(() => {
		if (initialized) {
			locale.setLang('vi');
		}
	}, [initialized]);

	useEffect(() => {
		if (content && !isContentParsed) {
			ref.current?.editor?.commands.setContent(content);
			setIsContentParsed(true);
		}
	}, [isContentParsed, content]);

	return (
		<div className={'outline-1 outline-neutral-00 *:outline-0'}>
			<RcTiptapEditor
				ref={ref}
				useEditorOptions={{
					immediatelyRender: false,
					editorProps: {
						attributes: {
							class: '!p-2 font-sm *:text-base *:text-neutral-600 *:!m-0',
						},
					},
				}}
				hideBubble={true}
				output="html"
				content={content}
				onChangeContent={(val: string) =>
					isContentParsed && onChange(val)
				}
				extensions={extensions}
				dark={false}
				contentClass={'p-0'}
			/>
		</div>
	);
};

export default Editor;
