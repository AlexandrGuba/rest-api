<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends Controller
{
	/**
	 * Получение списка задач
	 * @Rest\Get("/api/tasks", name="get_task")
	 */
	public function getTask()
	{
		$task = $this->getDoctrine()->getRepository('AppBundle:Task')->findAll();
		
		$data = [];
		
		foreach ($task as $item) {
			$data[] = [
				'id' => $item->getIdTask(),
				'title' => $item->getTitle(),
				'description' => $item->getDescription(),
				'sprint' => $item->getSprintId(),
			];
		}
		
		return new JsonResponse($data, 200);
		
	}
	
	/**
	 * Добавление задачи
	 * @Rest\Post("/api/tasks", name="post_task")
	 * @param Request $request
	 * @return mixed
	 */
	public function postTask(Request $request)
	{
		$errors = [];
		if (null == trim($request->get('Title')))
		{
			$errors['Errors']['Fields'][] = ['Title' => "Укажите заголовок задачи"];
		}
		
		if (null == trim($request->get('Description')))
		{
			$errors['Errors']['Fields'][] = ['Description' => "Укажите описание задачи"];
		}
		
		if (!empty($errors))
		{
			return new JsonResponse($errors, 400);
		}
		
		$task = new Task();

		$task->setIdTask('TASK-');
		$task->setTitle($request->get('Title'));
		$task->setDescription($request->get('Description'));
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($task);
		$em->flush();
		
		$task->setIdTask($task->getIdTask().$task->getId());
		$em->persist($task);
		$em->flush();
		
		$response = ['id' => $task->getIdTask()];

		return new JsonResponse($response, 200);
		
	}
	
	/**
	 * Оценка задачи
	 * @Rest\Post("/api/estimate/task", name="post_estimate_task")
	 * @param Request $request
	 * @return mixed
	 */
	public function postEstimateTask(Request $request)
	{
		$errors = [];
		if (null == trim($request->get('id')))
		{
			$errors['Errors']['Fields'][] = ['Id' => "Не указан id задачи"];
		}
		
		if (null == trim($request->get('estimation')))
		{
			$errors['Errors']['Fields'][] = ['Estimation' => "Не указана оценка задачи"];
		}
		
		if (!empty($errors))
		{
			return new JsonResponse($errors, 400);
		}
		
		$task = $this->getDoctrine()->getRepository('AppBundle:Task')->findOneBy(['id_task' => $request->get('id')]);
		
		if (null == $task)
		{
			$errors['Errors']['Fields'][] = ['Task' => "Указанная задача отсуцтвует"];
		}
		
		if (!empty($errors))
		{
			return new JsonResponse($errors, 400);
		}
		
		$timeTask = $request->get('estimation');
		
		$timeTask  = str_replace(" ", "", $timeTask);  // 3d5h30m
		$time = 0;
		
		$day = stripos($timeTask, 'd');
		$hour = stripos($timeTask, 'h');
		$minute = stripos($timeTask, 'm');
		
		if ($day)
		{
			$time += (substr($timeTask, 0, $day)) *24*60;
			$day++;
		}
		
		if ($hour)
		{
			$time += (substr($timeTask, $day, $hour-$day)) *60;
			$hour++;
		}
		
		$time += substr($timeTask, $hour, $minute-$hour);
		
		$task->setEstimation($time);
		$em = $this->getDoctrine()->getManager();
		$em->persist($task);
		$em->flush();

		
		$response = [
			'id' => $task->getIdTask(),
			'estimation' => $task->getEstimation(),
		];
		return new JsonResponse($response, 200);
		
	}
	
	/**
	 * Закрытие задачи
	 * @Rest\Post("/api/tasks/close", name="post_task_close")
	 * @param Request $request
	 * @return mixed
	 */
	public function postTaskClose(Request $request)
	{
		
		$task = $this->getDoctrine()->getRepository('AppBundle:Task')->findOneBy(['id_task' => $request->get('taskId')]);
		
		if (null == $task)
		{
			$errors['Errors']['Fields'][] = ['Task' => "Указанная задача отсуцтвует"];
		}
		
		if (!empty($errors))
		{
			return new JsonResponse($errors, 400);
		}
		
		$task->setAction(true);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($task);
		$em->flush();
		
		$response = [
		  'taskId' => $task->getIdTask(),
		];
		return new JsonResponse($response, 200);
	}
	
}
