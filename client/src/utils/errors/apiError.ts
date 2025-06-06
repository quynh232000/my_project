import { AxiosError } from 'axios';

export type ValidationErrorPayload = {
	status: boolean;
	message: string;
	error: {
		code: number;
		details: Record<string, string>;
	};
};

export class HttpError<
	TPayload = { message: string; [key: string]: unknown },
> extends Error {
	status: number;
	payload: TPayload;

	constructor({
		status,
		payload,
		message = 'Lỗi HTTP',
	}: {
		status: number;
		payload: TPayload;
		message?: string;
	}) {
		super(message);
		this.status = status;
		this.payload = payload;
		Object.setPrototypeOf(this, HttpError.prototype);
	}
}

export class APIValidationError extends HttpError<ValidationErrorPayload> {
	constructor({
		status,
		payload,
	}: {
		status: number;
		payload: ValidationErrorPayload;
	}) {
		super({
			status,
			payload,
			message: payload?.message || 'Lỗi xác thực',
		});
		Object.setPrototypeOf(this, APIValidationError.prototype);
	}
}


export function handleAPIError(err: unknown) {
	const error = err as AxiosError;
	const status = error?.response?.status;
	const payload = error?.response?.data;

	if (status && (status === 422 || status === 400)) {
		throw new APIValidationError({
			status,
			payload: payload as ValidationErrorPayload,
		});
	}

	throw new HttpError({
		status: status as number,
		payload,
	});
}