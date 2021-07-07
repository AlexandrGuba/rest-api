<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sprint;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;


class SprintController extends Controller
{
	/**
	 * Создание спринта
	 * @Rest\Post("/api/sprints", name="post_sprint")
	 * @param Request $request
	 * @return mixed
	 */
	public function postSprint(Request $request)
	{
		
		$week = ( trim($request->get('Week')) );
		$year = ( trim(substr($request->get('Year'), -2)) );
		
		if (is_numeric($week) == false || is_numeric($year) == false)
		{
			$errors['Errors']['Fields'][] = ['Date' => "Не верная дата спринта"];
			return new JsonResponse($errors, 400);
		}else{
			$idSprint = $year.'-'.$week;
		}
		
		$sprint = $this->getDoctrine()->getRepository('AppBundle:Sprint')->findOneBy(['idSprint' => $idSprint]);
		
		if (!empty($sprint))
		{
			$errors['Errors']['Fields'][] = ['Sprint' => "Указанный спринт уже существует"];
			return new JsonResponse($errors, 400);
		}else{
			$sprint = new Sprint();
			$sprint->setIdSprint($idSprint);
		}

		$em = $this->getDoctrine()->getManager();
		$em->persist($sprint);
		$em->flush();
		
		$response = [
		  'id' => $sprint->getIdSprint(),
		];
		
		return new JsonResponse($response, 200);
		
	}
	
	/**
	 * Добавление задачи в спринт
	 * @Rest\Post("/api/sprints/add-task", name="post_sprint_add_task")
	 * @param Request $request
	 * @return mixed
	 */
	public function postSprintAddTask(Request $request)
	{
		
		$taskId = $request->get('taskId');
		$sprintId = $request->get('sprintId');
		
		$task = $this->getDoctrine()->getRepository('AppBundle:Task')->findOneBy(['id_task' => $taskId]);
		$sprint = $this->getDoctrine()->getRepository('AppBundle:Sprint')->findOneBy(['idSprint' => $sprintId]);
		
		$errors = [];
		
		if (null == $task)
		{
			$errors['Errors']['Fields'][] = ['Task' => "Указанная задача отсуцтвует"];
		}
		
		if (null == $sprint)
		{
			$errors['Errors']['Fields'][] = ['Sprint' => "Указанный спринт отсуцтвует"];
		}
		
		if (!empty($errors))
		{
			return new JsonResponse($errors, 400);
		}
		
		$task->setSprintId($sprint->getIdSprint());
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($task);
		$em->flush();
		
		
		$response = [
		 	'sprintId' => $sprint->getIdSprint(),
			'taskId' => $task->getIdTask(),
		];
		
		return new JsonResponse($response, 200);
		
	}
	
	/**
	 * Запуск спринта
	 * @Rest\Post("/api/sprints/start", name="post_sprint_start")
	 * @param Request $request
	 * @return mixed
	 */
	public function postSprintStart(Request $request)
	{
		$sprintId = $request->get('sprintId');
		
		$sprint = $this->getDoctrine()->getRepository('AppBundle:Sprint')->findOneBy(['idSprint' => $sprintId]);
		$tasks = $this->getDoctrine()->getRepository('AppBundle:Task')->findBy(['sprint_id' => $sprintId]);
		
		$sumTime = 0;
		$errors = [];
		
		if (null == $sprint)
		{
			$errors['Errors']['Fields'][] = ['Sprint' => "Указанный спринт отсуцтвует"];
		}
		
		foreach ($tasks as $task)
		{
			if ($task->getEstimation() > 0)
			{
				$sumTime += $task->getEstimation();
			}else {
				$errors['Errors']['Global'][] = ['Estimate' => "Невозможно начать спринт. Оцение задачи"];
				break;
			}
		}
		
		if ($sumTime > 2400)
		{
			$errors['Errors']['Global'][] = ['Time' => "Суммарная оценка задач более 40 часов"];
		}
		
		$sprintWork = $this->getDoctrine()->getRepository('AppBundle:Sprint')->findOneBy(['status' => 1]);
		if ($sprintWork)
		{
			$errors['Errors']['Global'][] = ['Sprint' => "Имеется спринт в работе"];
		}
		
		
		if (!empty($errors))
		{
			return new JsonResponse($errors, 400);
		}else {
			
			$sprint->setStatus(1);
			$em = $this->getDoctrine()->getManager();
			$em->persist($sprint);
			$em->flush();
		}
		
		$response = [
		  'sprintId' => $sprint->getIdSprint(),
		];
		
		return new JsonResponse($response, 200);
		
	}
	
}
